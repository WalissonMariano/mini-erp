<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Cadastro\Clientes;
use App\Models\Cadastro\Empresa;
use App\Models\Financeiro\ContasReceber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContasReceberController extends Controller
{
    public function index()
    {
        $contas = ContasReceber::with(['empresa', 'cliente'])
            ->orderByDesc('data_vencimento')
            ->orderByDesc('created_at')
            ->get();

        return view('financeiro.contas-receber.index-contas-receber', compact('contas'));
    }

    public function create()
    {
        $conta = null;
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $clientes = Clientes::orderBy('str_nome')->get();

        return view('financeiro.contas-receber.form-contas-receber', compact('conta', 'empresas', 'clientes'));
    }

    public function edit($id)
    {
        $conta = ContasReceber::findOrFail($id);
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $clientes = Clientes::orderBy('str_nome')->get();

        return view('financeiro.contas-receber.form-contas-receber', compact('conta', 'empresas', 'clientes'));
    }

    public function store(Request $request)
    {
        $validated = $this->validarConta($request);
        $validated['status'] = ContasReceber::STATUS_ABERTO;
        $validated['data_recebimento'] = null;

        ContasReceber::create($validated);

        return redirect()->route('pagina.lista.contas_receber')->with('success', 'Conta a receber criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $conta = ContasReceber::findOrFail($id);

        $validated = $this->validarConta($request, $conta);

        if ($conta->status === ContasReceber::STATUS_PAGO && $validated['status'] !== ContasReceber::STATUS_PAGO) {
            return back()
                ->withErrors(['status' => 'Título recebido não pode ser reaberto.'])
                ->withInput();
        }

        if ($conta->status !== ContasReceber::STATUS_PAGO) {
            $validated['data_recebimento'] = null;
        }

        $conta->update($validated);

        return redirect()->route('pagina.lista.contas_receber')->with('success', 'Conta a receber atualizada com sucesso!');
    }

    public function baixar($id)
    {
        $conta = ContasReceber::findOrFail($id);

        if ($conta->status !== ContasReceber::STATUS_ABERTO) {
            return back()->withErrors(['status' => 'Apenas títulos abertos podem ser baixados.']);
        }

        $conta->update([
            'status' => ContasReceber::STATUS_PAGO,
            'data_recebimento' => today()->toDateString(),
        ]);

        return redirect()->route('pagina.editar.conta_receber', ['id' => $conta->id])
            ->with('success', 'Título baixado com sucesso!');
    }

    public function destroy($id)
    {
        $conta = ContasReceber::findOrFail($id);
        $conta->delete();

        return redirect()->route('pagina.lista.contas_receber')->with('success', 'Conta a receber excluida com sucesso!');
    }

    private function validarConta(Request $request, ?ContasReceber $conta = null): array
    {
        $statusAtual = old('status', optional($conta)->status ?? ContasReceber::STATUS_ABERTO);
        if (! in_array($statusAtual, [ContasReceber::STATUS_ABERTO, ContasReceber::STATUS_PAGO, ContasReceber::STATUS_CANCELADO], true)) {
            $statusAtual = ContasReceber::STATUS_ABERTO;
        }

        $request->merge(['status' => $statusAtual]);

        return $request->validate(
            [
                'empresa_id' => 'required|uuid|exists:empresa,id',
                'cliente_id' => 'required|uuid|exists:clientes,id',
                'str_descricao' => 'required|string|max:255',
                'dbl_valor' => 'required|numeric|min:0',
                'data_vencimento' => 'required|date',
                'status' => ['required', 'string', 'max:20', Rule::in([ContasReceber::STATUS_ABERTO, ContasReceber::STATUS_PAGO, ContasReceber::STATUS_CANCELADO])],
                'str_observacao' => 'nullable|string',
            ],
            [
                'empresa_id.required' => 'Selecione a empresa.',
                'cliente_id.required' => 'Selecione o cliente.',
                'str_descricao.required' => 'Informe a descrição.',
                'dbl_valor.required' => 'Informe o valor.',
                'data_vencimento.required' => 'Informe a data de vencimento.',
            ],
            [
                'empresa_id' => 'empresa',
                'cliente_id' => 'cliente',
                'str_descricao' => 'descrição',
                'dbl_valor' => 'valor',
                'data_vencimento' => 'vencimento',
                'status' => 'status',
                'str_observacao' => 'observação',
            ]
        );
    }
}
