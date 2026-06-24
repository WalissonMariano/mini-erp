<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Cadastro\Empresa;
use App\Models\Cadastro\Fornecedores;
use App\Models\Financeiro\ContasPagar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContasPagarController extends Controller
{
    public function index()
    {
        $contas = ContasPagar::with(['empresa', 'fornecedor'])
            ->orderByDesc('data_vencimento')
            ->orderByDesc('created_at')
            ->get();

        return view('financeiro.contas-pagar.index-contas-pagar', compact('contas'));
    }

    public function create()
    {
        $conta = null;
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $fornecedores = Fornecedores::orderBy('str_nome')->get();

        return view('financeiro.contas-pagar.form-contas-pagar', compact('conta', 'empresas', 'fornecedores'));
    }

    public function edit($id)
    {
        $conta = ContasPagar::findOrFail($id);
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $fornecedores = Fornecedores::orderBy('str_nome')->get();

        return view('financeiro.contas-pagar.form-contas-pagar', compact('conta', 'empresas', 'fornecedores'));
    }

    public function store(Request $request)
    {
        $validated = $this->validarConta($request);
        $validated['status'] = ContasPagar::STATUS_ABERTO;
        $validated['data_pagamento'] = null;

        ContasPagar::create($validated);

        return redirect()->route('pagina.lista.contas_pagar')->with('success', 'Conta a pagar criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $conta = ContasPagar::findOrFail($id);

        $validated = $this->validarConta($request, $conta);

        if ($conta->status === ContasPagar::STATUS_PAGO && $validated['status'] !== ContasPagar::STATUS_PAGO) {
            return back()
                ->withErrors(['status' => 'Título pago não pode ser reaberto.'])
                ->withInput();
        }

        if ($conta->status !== ContasPagar::STATUS_PAGO) {
            $validated['data_pagamento'] = null;
        }

        $conta->update($validated);

        return redirect()->route('pagina.lista.contas_pagar')->with('success', 'Conta a pagar atualizada com sucesso!');
    }

    public function baixar($id)
    {
        $conta = ContasPagar::findOrFail($id);

        if ($conta->status !== ContasPagar::STATUS_ABERTO) {
            return back()->withErrors(['status' => 'Apenas títulos abertos podem ser baixados.']);
        }

        $conta->update([
            'status' => ContasPagar::STATUS_PAGO,
            'data_pagamento' => today()->toDateString(),
        ]);

        return redirect()->route('pagina.editar.conta_pagar', ['id' => $conta->id])
            ->with('success', 'Título baixado com sucesso!');
    }

    public function destroy($id)
    {
        $conta = ContasPagar::findOrFail($id);
        $conta->delete();

        return redirect()->route('pagina.lista.contas_pagar')->with('success', 'Conta a pagar excluida com sucesso!');
    }

    private function validarConta(Request $request, ?ContasPagar $conta = null): array
    {
        $statusAtual = old('status', optional($conta)->status ?? ContasPagar::STATUS_ABERTO);
        if (! in_array($statusAtual, [ContasPagar::STATUS_ABERTO, ContasPagar::STATUS_PAGO, ContasPagar::STATUS_CANCELADO], true)) {
            $statusAtual = ContasPagar::STATUS_ABERTO;
        }

        $request->merge(['status' => $statusAtual]);

        return $request->validate(
            [
                'empresa_id' => 'required|uuid|exists:empresa,id',
                'fornecedores_id' => 'required|uuid|exists:fornecedores,id',
                'str_descricao' => 'required|string|max:255',
                'dbl_valor' => 'required|numeric|min:0',
                'data_vencimento' => 'required|date',
                'status' => ['required', 'string', 'max:20', Rule::in([ContasPagar::STATUS_ABERTO, ContasPagar::STATUS_PAGO, ContasPagar::STATUS_CANCELADO])],
                'str_observacao' => 'nullable|string',
            ],
            [
                'empresa_id.required' => 'Selecione a empresa.',
                'fornecedores_id.required' => 'Selecione o fornecedor.',
                'str_descricao.required' => 'Informe a descrição.',
                'dbl_valor.required' => 'Informe o valor.',
                'data_vencimento.required' => 'Informe a data de vencimento.',
            ],
            [
                'empresa_id' => 'empresa',
                'fornecedores_id' => 'fornecedor',
                'str_descricao' => 'descrição',
                'dbl_valor' => 'valor',
                'data_vencimento' => 'vencimento',
                'status' => 'status',
                'str_observacao' => 'observação',
            ]
        );
    }
}
