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

        return view('financeiro.contas_pagar.index_contas_pagar', compact('contas'));
    }

    public function create()
    {
        $conta = null;
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $fornecedores = Fornecedores::orderBy('str_nome')->get();

        return view('financeiro.contas_pagar.form_contas_pagar', compact('conta', 'empresas', 'fornecedores'));
    }

    public function edit($id)
    {
        $conta = ContasPagar::findOrFail($id);
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $fornecedores = Fornecedores::orderBy('str_nome')->get();

        return view('financeiro.contas_pagar.form_contas_pagar', compact('conta', 'empresas', 'fornecedores'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'fornecedores_id' => $request->filled('fornecedores_id') ? $request->input('fornecedores_id') : null,
        ]);

        $validated = $request->validate([
            'empresa_id' => 'required|uuid|exists:empresa,id',
            'fornecedores_id' => 'nullable|uuid|exists:fornecedores,id',
            'str_descricao' => 'nullable|string|max:255',
            'dbl_valor' => 'required|numeric|min:0',
            'data_vencimento' => 'required|date',
            'data_pagamento' => 'nullable|date',
            'status' => ['required', 'string', 'max:20', Rule::in(['aberto', 'pago', 'cancelado'])],
            'str_observacao' => 'nullable|string',
        ]);

        $validated['fornecedores_id'] = $validated['fornecedores_id'] ?? null;

        ContasPagar::create($validated);

        return redirect()->route('pagina.lista.contas_pagar')->with('success', 'Conta a pagar criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $conta = ContasPagar::findOrFail($id);

        $request->merge([
            'fornecedores_id' => $request->filled('fornecedores_id') ? $request->input('fornecedores_id') : null,
        ]);

        $validated = $request->validate([
            'empresa_id' => 'required|uuid|exists:empresa,id',
            'fornecedores_id' => 'nullable|uuid|exists:fornecedores,id',
            'str_descricao' => 'nullable|string|max:255',
            'dbl_valor' => 'required|numeric|min:0',
            'data_vencimento' => 'required|date',
            'data_pagamento' => 'nullable|date',
            'status' => ['required', 'string', 'max:20', Rule::in(['aberto', 'pago', 'cancelado'])],
            'str_observacao' => 'nullable|string',
        ]);

        $validated['fornecedores_id'] = $validated['fornecedores_id'] ?? null;

        $conta->update($validated);

        return redirect()->route('pagina.lista.contas_pagar')->with('success', 'Conta a pagar atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $conta = ContasPagar::findOrFail($id);
        $conta->delete();

        return redirect()->route('pagina.lista.contas_pagar')->with('success', 'Conta a pagar excluida com sucesso!');
    }
}
