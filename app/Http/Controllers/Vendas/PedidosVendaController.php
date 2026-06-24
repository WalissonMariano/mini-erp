<?php

namespace App\Http\Controllers\Vendas;

use App\Http\Controllers\Controller;
use App\Models\Cadastro\Clientes;
use App\Models\Cadastro\Empresa;
use App\Models\Cadastro\Vendedores;
use App\Models\Estoque\Itens;
use App\Models\Configuracao\Parametros;
use App\Models\Financeiro\ContasReceber;
use App\Models\Venda\PedidosVenda;
use App\Models\Venda\PedidosVendaItens;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PedidosVendaController extends Controller
{
    public function index()
    {
        $pedidosVenda = PedidosVenda::with(['empresa', 'cliente', 'vendedor'])
            ->withCount('itens')
            ->orderByDesc('data_pedido')
            ->orderByDesc('created_at')
            ->get();

        return view('vendas.pedidos-venda.index-pedidos-vendas', compact('pedidosVenda'));
    }

    public function create()
    {
        $pedidoVenda = null;
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $clientes = Clientes::orderBy('str_nome')->get();
        $vendedores = Vendedores::orderBy('str_nome')->get();
        $catalogoItens = Itens::orderBy('str_descricao')->get();
        $itensFormRows = $this->itensFormRowsFromOldOrDefault(null, request());

        return view('vendas.pedidos-venda.form-pedidos-vendas', compact(
            'pedidoVenda',
            'empresas',
            'clientes',
            'vendedores',
            'catalogoItens',
            'itensFormRows'
        ));
    }

    public function edit($id)
    {
        $pedidoVenda = PedidosVenda::with(['itens' => fn ($q) => $q->orderBy('created_at')])->findOrFail($id);
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $clientes = Clientes::orderBy('str_nome')->get();
        $vendedores = Vendedores::orderBy('str_nome')->get();
        $catalogoItens = Itens::orderBy('str_descricao')->get();
        $itensFormRows = $this->itensFormRowsFromOldOrDefault($pedidoVenda, request());

        return view('vendas.pedidos-venda.form-pedidos-vendas', compact(
            'pedidoVenda',
            'empresas',
            'clientes',
            'vendedores',
            'catalogoItens',
            'itensFormRows'
        ));
    }

    public function store(Request $request)
    {
        $request->merge([
            'cliente_id' => $request->filled('cliente_id') ? $request->input('cliente_id') : null,
            'vendedor_id' => $request->filled('vendedor_id') ? $request->input('vendedor_id') : null,
        ]);

        $linhas = $this->filtrarLinhasItens($request);
        if ($linhas->isEmpty()) {
            return back()
                ->withErrors(['itens' => 'Informe pelo menos uma linha de item com produto selecionado.'])
                ->withInput();
        }

        $request->merge(['itens' => $linhas->values()->all()]);

        $validated = $this->validarPedido($request);

        $cabecalho = $this->normalizarCabecalho($validated);
        $cabecalho['status'] = PedidosVenda::STATUS_ABERTO;

        DB::transaction(function () use ($cabecalho, $linhas) {
            $cabecalho['numero_pedido'] = PedidosVenda::proximoNumeroPedido();
            $pedido = PedidosVenda::create($cabecalho);
            $this->gravarLinhasItens($pedido, $linhas);
            $this->atualizarTotalPedido($pedido);
        });

        return redirect()->route('pagina.lista.pedidos_venda')->with('success', 'Pedido de venda criado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'cliente_id' => $request->filled('cliente_id') ? $request->input('cliente_id') : null,
            'vendedor_id' => $request->filled('vendedor_id') ? $request->input('vendedor_id') : null,
        ]);

        $pedidoVenda = PedidosVenda::findOrFail($id);

        $linhas = $this->filtrarLinhasItens($request);
        if ($linhas->isEmpty()) {
            return back()
                ->withErrors(['itens' => 'Informe pelo menos uma linha de item com produto selecionado.'])
                ->withInput();
        }

        $request->merge(['itens' => $linhas->values()->all()]);

        $validated = $this->validarPedido($request);

        $cabecalho = $this->normalizarCabecalho($validated);

        if ($pedidoVenda->status === PedidosVenda::STATUS_BAIXADO && $cabecalho['status'] !== PedidosVenda::STATUS_BAIXADO) {
            return back()
                ->withErrors(['status' => 'Pedido baixado não pode ser reaberto.'])
                ->withInput();
        }

        DB::transaction(function () use ($pedidoVenda, $cabecalho, $linhas) {
            $pedidoVenda->update($cabecalho);
            $pedidoVenda->itens()->forceDelete();
            $this->gravarLinhasItens($pedidoVenda, $linhas);
            $this->atualizarTotalPedido($pedidoVenda->fresh());
        });

        return redirect()->route('pagina.lista.pedidos_venda')->with('success', 'Pedido de venda atualizado com sucesso!');
    }

    public function baixar($id)
    {
        $pedidoVenda = PedidosVenda::findOrFail($id);

        if ($pedidoVenda->status !== PedidosVenda::STATUS_ABERTO) {
            return back()->withErrors(['status' => 'Apenas pedidos abertos podem ser baixados.']);
        }

        DB::transaction(function () use ($pedidoVenda): void {
            $pedidoVenda->update(['status' => PedidosVenda::STATUS_BAIXADO]);

            if (Parametros::configuracao()->geraFinanceiro()) {
                $this->gerarContaReceberDoPedido($pedidoVenda->fresh());
            }
        });

        return redirect()->route('pagina.editar.pedido_venda', ['id' => $pedidoVenda->id])
            ->with('success', 'Pedido baixado com sucesso!');
    }

    public function destroy($id)
    {
        $pedidoVenda = PedidosVenda::findOrFail($id);
        $pedidoVenda->itens()->forceDelete();
        $pedidoVenda->delete();

        return redirect()->route('pagina.lista.pedidos_venda')->with('success', 'Pedido de venda deletado com sucesso!');
    }

    private function itensFormRowsFromOldOrDefault(?PedidosVenda $pedidoVenda, Request $request): array
    {
        $old = $request->old('itens');
        if (is_array($old) && count($old) > 0) {
            return array_values($old);
        }

        if ($pedidoVenda && $pedidoVenda->itens->isNotEmpty()) {
            return $pedidoVenda->itens->map(fn (PedidosVendaItens $l) => [
                'itens_id' => $l->itens_id,
                'dbl_quantidade' => (string) $l->dbl_quantidade,
                'dbl_valor_unitario' => (string) $l->dbl_valor_unitario,
            ])->all();
        }

        return [['itens_id' => '', 'dbl_quantidade' => '', 'dbl_valor_unitario' => '']];
    }

    private function filtrarLinhasItens(Request $request): Collection
    {
        return collect($request->input('itens', []))
            ->filter(fn ($r) => is_array($r) && ! empty($r['itens_id']));
    }

    private function validarPedido(Request $request): array
    {
        return $request->validate(
            [
                'empresa_id' => 'required|uuid|exists:empresa,id',
                'cliente_id' => 'required|uuid|exists:clientes,id',
                'vendedor_id' => 'required|uuid|exists:vendedores,id',
                'data_pedido' => 'required|date',
                'status' => ['required', 'string', Rule::in([PedidosVenda::STATUS_ABERTO, PedidosVenda::STATUS_BAIXADO])],
                'str_observacao' => 'nullable|string',
                'itens' => 'required|array|min:1',
                'itens.*.itens_id' => 'required|uuid|exists:itens,id',
                'itens.*.dbl_quantidade' => 'required|numeric|min:0',
                'itens.*.dbl_valor_unitario' => 'required|numeric|min:0',
            ],
            [
                'empresa_id.required' => 'Selecione a empresa.',
                'cliente_id.required' => 'Selecione o cliente.',
                'vendedor_id.required' => 'Selecione o vendedor.',
                'data_pedido.required' => 'Informe a data do pedido.',
                'itens.*.itens_id.required' => 'Selecione o produto na linha :position.',
                'itens.*.dbl_quantidade.required' => 'Informe a quantidade na linha :position.',
                'itens.*.dbl_quantidade.numeric' => 'A quantidade na linha :position deve ser numérica.',
                'itens.*.dbl_quantidade.min' => 'A quantidade na linha :position não pode ser negativa.',
                'itens.*.dbl_valor_unitario.required' => 'Informe o valor unitário na linha :position.',
                'itens.*.dbl_valor_unitario.numeric' => 'O valor unitário na linha :position deve ser numérico.',
                'itens.*.dbl_valor_unitario.min' => 'O valor unitário na linha :position não pode ser negativo.',
            ],
            [
                'empresa_id' => 'empresa',
                'cliente_id' => 'cliente',
                'vendedor_id' => 'vendedor',
                'data_pedido' => 'data do pedido',
                'status' => 'status',
                'str_observacao' => 'observação',
                'itens' => 'itens do pedido',
                'itens.*.itens_id' => 'produto',
                'itens.*.dbl_quantidade' => 'quantidade',
                'itens.*.dbl_valor_unitario' => 'valor unitário',
            ]
        );
    }

    private function normalizarCabecalho(array $validated): array
    {
        $out = [
            'empresa_id' => $validated['empresa_id'],
            'data_pedido' => $validated['data_pedido'],
            'status' => $validated['status'],
            'str_observacao' => $validated['str_observacao'] ?? null,
            'dbl_valor_total' => 0,
        ];
        $out['cliente_id'] = $validated['cliente_id'];
        $out['vendedor_id'] = $validated['vendedor_id'];

        return $out;
    }

    private function gravarLinhasItens(PedidosVenda $pedido, Collection $linhas): void
    {
        foreach ($linhas as $row) {
            $q = (float) $row['dbl_quantidade'];
            $u = (float) $row['dbl_valor_unitario'];
            $total = round($q * $u, 2);

            $pedido->itens()->create([
                'itens_id' => $row['itens_id'],
                'dbl_quantidade' => $q,
                'dbl_valor_unitario' => $u,
                'dbl_valor_total' => $total,
            ]);
        }
    }

    private function atualizarTotalPedido(PedidosVenda $pedido): void
    {
        $soma = (float) $pedido->itens()->sum('dbl_valor_total');
        $pedido->update(['dbl_valor_total' => $soma]);
    }

    private function gerarContaReceberDoPedido(PedidosVenda $pedido): void
    {
        $numero = $pedido->numero_pedido;
        $descricao = $numero !== null
            ? "nº {$numero}"
            : 'nº —';

        ContasReceber::create([
            'empresa_id' => $pedido->empresa_id,
            'cliente_id' => $pedido->cliente_id,
            'str_descricao' => $descricao,
            'dbl_valor' => $pedido->dbl_valor_total,
            'data_vencimento' => $pedido->data_pedido,
            'data_recebimento' => null,
            'status' => ContasReceber::STATUS_ABERTO,
            'str_observacao' => $pedido->str_observacao,
        ]);
    }
}
