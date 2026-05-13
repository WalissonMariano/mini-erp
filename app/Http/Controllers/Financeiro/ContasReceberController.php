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

        return view('financeiro.contas_receber.index_contas_receber', compact('contas'));
    }

    public function create()
    {
        $conta = null;
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $clientes = Clientes::orderBy('str_nome')->get();

        return view('financeiro.contas_receber.form_contas_receber', compact('conta', 'empresas', 'clientes'));
    }

    public function edit($id)
    {
        $conta = ContasReceber::findOrFail($id);
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $clientes = Clientes::orderBy('str_nome')->get();

        return view('financeiro.contas_receber.form_contas_receber', compact('conta', 'empresas', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'cliente_id' => $request->filled('cliente_id') ? $request->input('cliente_id') : null,
        ]);

        $validated = $request->validate([
            'empresa_id' => 'required|uuid|exists:empresa,id',
            'cliente_id' => 'nullable|uuid|exists:clientes,id',
            'str_descricao' => 'nullable|string|max:255',
            'dbl_valor' => 'required|numeric|min:0',
            'data_vencimento' => 'required|date',
            'data_recebimento' => 'nullable|date',
            'status' => ['required', 'string', 'max:20', Rule::in(['aberto', 'pago', 'cancelado'])],
            'str_observacao' => 'nullable|string',
        ]);

        $validated['cliente_id'] = $validated['cliente_id'] ?? null;

        ContasReceber::create($validated);

        return redirect()->route('pagina.lista.contas_receber')->with('success', 'Conta a receber criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $conta = ContasReceber::findOrFail($id);

        $request->merge([
            'cliente_id' => $request->filled('cliente_id') ? $request->input('cliente_id') : null,
        ]);

        $validated = $request->validate([
            'empresa_id' => 'required|uuid|exists:empresa,id',
            'cliente_id' => 'nullable|uuid|exists:clientes,id',
            'str_descricao' => 'nullable|string|max:255',
            'dbl_valor' => 'required|numeric|min:0',
            'data_vencimento' => 'required|date',
            'data_recebimento' => 'nullable|date',
            'status' => ['required', 'string', 'max:20', Rule::in(['aberto', 'pago', 'cancelado'])],
            'str_observacao' => 'nullable|string',
        ]);

        $validated['cliente_id'] = $validated['cliente_id'] ?? null;

        $conta->update($validated);

        return redirect()->route('pagina.lista.contas_receber')->with('success', 'Conta a receber atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $conta = ContasReceber::findOrFail($id);
        $conta->delete();

        return redirect()->route('pagina.lista.contas_receber')->with('success', 'Conta a receber excluida com sucesso!');
    }
}
