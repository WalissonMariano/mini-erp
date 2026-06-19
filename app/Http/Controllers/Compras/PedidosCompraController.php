<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\Cadastro\Empresa;
use App\Models\Cadastro\Fornecedores;
use App\Models\Compras\PedidosCompra;
use App\Models\Compras\PedidosCompraItens;
use App\Models\Estoque\Itens;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PedidosCompraController extends Controller
{
    public function index()
    {
        $pedidosCompra = PedidosCompra::with(['empresa', 'fornecedor'])
            ->withCount('itens')
            ->orderByDesc('data_pedido')
            ->orderByDesc('created_at')
            ->get();

        return view('compras.pedidos-compra.index-pedidos-compras', compact('pedidosCompra'));
    }

    public function create()
    {
        $pedidoCompra = null;
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $fornecedores = Fornecedores::orderBy('str_nome')->get();
        $catalogoItens = Itens::orderBy('str_descricao')->get();
        $itensFormRows = $this->itensFormRowsFromOldOrDefault(null, request());

        return view('compras.pedidos-compra.form-pedidos-compras', compact(
            'pedidoCompra',
            'empresas',
            'fornecedores',
            'catalogoItens',
            'itensFormRows'
        ));
    }

    public function edit($id)
    {
        $pedidoCompra = PedidosCompra::with(['itens' => fn ($q) => $q->orderBy('created_at')])->findOrFail($id);
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $fornecedores = Fornecedores::orderBy('str_nome')->get();
        $catalogoItens = Itens::orderBy('str_descricao')->get();
        $itensFormRows = $this->itensFormRowsFromOldOrDefault($pedidoCompra, request());

        return view('compras.pedidos-compra.form-pedidos-compras', compact(
            'pedidoCompra',
            'empresas',
            'fornecedores',
            'catalogoItens',
            'itensFormRows'
        ));
    }

    public function store(Request $request)
    {
        $request->merge([
            'fornecedores_id' => $request->filled('fornecedores_id') ? $request->input('fornecedores_id') : null,
        ]);

        $linhas = $this->filtrarLinhasItens($request);
        if ($linhas->isEmpty()) {
            return back()
                ->withErrors(['itens' => 'Informe pelo menos uma linha de item com produto selecionado.'])
                ->withInput();
        }

        $request->merge(['itens' => $linhas->values()->all()]);

        $validated = $request->validate([
            'empresa_id' => 'required|uuid|exists:empresa,id',
            'fornecedores_id' => 'required|uuid|exists:fornecedores,id',
            'data_pedido' => 'required|date',
            'status' => ['required', 'string', Rule::in([PedidosCompra::STATUS_ABERTO, PedidosCompra::STATUS_BAIXADO])],
            'str_observacao' => 'nullable|string',
            'itens' => 'required|array|min:1',
            'itens.*.item_id' => 'required|uuid|exists:itens,id',
            'itens.*.dbl_quantidade' => 'required|numeric|min:0',
            'itens.*.dbl_valor_unitario' => 'required|numeric|min:0',
        ]);

        $cabecalho = $this->normalizarCabecalho($validated);
        $cabecalho['status'] = PedidosCompra::STATUS_ABERTO;

        DB::transaction(function () use ($cabecalho, $linhas) {
            $pedido = PedidosCompra::create($cabecalho);
            $this->gravarLinhasItens($pedido, $linhas);
            $this->atualizarTotalPedido($pedido);
        });

        return redirect()->route('pagina.lista.pedidos_compra')->with('success', 'Pedido de compra criado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'fornecedores_id' => $request->filled('fornecedores_id') ? $request->input('fornecedores_id') : null,
        ]);

        $pedidoCompra = PedidosCompra::findOrFail($id);

        $linhas = $this->filtrarLinhasItens($request);
        if ($linhas->isEmpty()) {
            return back()
                ->withErrors(['itens' => 'Informe pelo menos uma linha de item com produto selecionado.'])
                ->withInput();
        }

        $request->merge(['itens' => $linhas->values()->all()]);

        $validated = $request->validate([
            'empresa_id' => 'required|uuid|exists:empresa,id',
            'fornecedores_id' => 'required|uuid|exists:fornecedores,id',
            'data_pedido' => 'required|date',
            'status' => ['required', 'string', Rule::in([PedidosCompra::STATUS_ABERTO, PedidosCompra::STATUS_BAIXADO])],
            'str_observacao' => 'nullable|string',
            'itens' => 'required|array|min:1',
            'itens.*.item_id' => 'required|uuid|exists:itens,id',
            'itens.*.dbl_quantidade' => 'required|numeric|min:0',
            'itens.*.dbl_valor_unitario' => 'required|numeric|min:0',
        ]);

        $cabecalho = $this->normalizarCabecalho($validated);

        if ($pedidoCompra->status === PedidosCompra::STATUS_BAIXADO && $cabecalho['status'] !== PedidosCompra::STATUS_BAIXADO) {
            return back()
                ->withErrors(['status' => 'Pedido baixado não pode ser reaberto.'])
                ->withInput();
        }

        DB::transaction(function () use ($pedidoCompra, $cabecalho, $linhas) {
            $pedidoCompra->update($cabecalho);
            $pedidoCompra->itens()->forceDelete();
            $this->gravarLinhasItens($pedidoCompra, $linhas);
            $this->atualizarTotalPedido($pedidoCompra->fresh());
        });

        return redirect()->route('pagina.lista.pedidos_compra')->with('success', 'Pedido de compra atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $pedidoCompra = PedidosCompra::findOrFail($id);
        $pedidoCompra->itens()->forceDelete();
        $pedidoCompra->delete();

        return redirect()->route('pagina.lista.pedidos_compra')->with('success', 'Pedido de compra deletado com sucesso!');
    }

    private function itensFormRowsFromOldOrDefault(?PedidosCompra $pedidoCompra, Request $request): array
    {
        $old = $request->old('itens');
        if (is_array($old) && count($old) > 0) {
            return array_values($old);
        }

        if ($pedidoCompra && $pedidoCompra->itens->isNotEmpty()) {
            return $pedidoCompra->itens->map(fn (PedidosCompraItens $l) => [
                'item_id' => $l->item_id,
                'dbl_quantidade' => (string) $l->dbl_quantidade,
                'dbl_valor_unitario' => (string) $l->dbl_valor_unitario,
            ])->all();
        }

        return [['item_id' => '', 'dbl_quantidade' => '', 'dbl_valor_unitario' => '']];
    }

    private function filtrarLinhasItens(Request $request): Collection
    {
        return collect($request->input('itens', []))
            ->filter(fn ($r) => is_array($r) && ! empty($r['item_id']));
    }

    private function normalizarCabecalho(array $validated): array
    {
        $out = [
            'empresa_id' => $validated['empresa_id'],
            'fornecedores_id' => $validated['fornecedores_id'],
            'data_pedido' => $validated['data_pedido'],
            'status' => $validated['status'],
            'str_observacao' => $validated['str_observacao'] ?? null,
            'dbl_valor_total' => 0,
        ];

        return $out;
    }

    private function gravarLinhasItens(PedidosCompra $pedido, Collection $linhas): void
    {
        foreach ($linhas as $row) {
            $q = (float) $row['dbl_quantidade'];
            $u = (float) $row['dbl_valor_unitario'];
            $total = round($q * $u, 2);

            PedidosCompraItens::create([
                'pedido_compra_id' => $pedido->id,
                'item_id' => $row['item_id'],
                'dbl_quantidade' => $q,
                'dbl_valor_unitario' => $u,
                'dbl_valor_total' => $total,
            ]);
        }
    }

    private function atualizarTotalPedido(PedidosCompra $pedido): void
    {
        $soma = (float) $pedido->itens()->sum('dbl_valor_total');
        $pedido->update(['dbl_valor_total' => $soma]);
    }
}
