<?php

namespace App\Http\Controllers\Cadastro;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Cadastro\Clientes;
use App\Models\Cadastro\Empresa;


class ClientesController extends Controller
{

    // Busca todos clientes
    public function index()
    {
        $clientes = Clientes::with('empresa')->orderBy('str_nome')->get();
        return view('cadastro/clientes/index_clientes', compact('clientes'));
    }

    // Busca cliente por id para edição
    public function edit($id)
    {
        $cliente = Clientes::findOrFail($id);
        $empresa = Empresa::findOrFail($cliente->empresa_id);
        return view('cadastro/clientes/form_clientes', compact('cliente', 'empresa'));
    }

    // Formulário de criação de cliente
    public function create()
    {
        $empresas = Empresa::all();
        return view('cadastro/clientes/form_clientes', compact('empresas'));
    }

    // Salva dados de um novo cliente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'str_nome' => 'required|string|max:150',
            'str_cpf' => 'required|string|unique:clientes|max:14',
            'str_email' => 'required|email|unique:clientes|max:120',
            'str_telefone' => 'nullable|string|max:20',
            'str_logradouro' => 'nullable|string|max:255',
            'str_numero' => 'nullable|string|max:20',
            'str_bairro' => 'nullable|string|max:100',
            'str_cidade' => 'nullable|string|max:100',
            'str_estado' => 'nullable|string|max:2',
            'empresa_id' => 'required|uuid|exists:empresa,id',
        ]);

        Clientes::create($validated);

        return redirect()->route('pagina.lista.clientes')->with('success', 'Cliente criado com sucesso!');
    }

    // Atualiza os dados do cliente
    public function update(Request $request, $id)
    {
        $cliente = Clientes::findOrFail($id);
        
        $validated = $request->validate([
            'str_nome' => 'required|string|max:150',
            'str_cpf' => 'required|string|max:14|unique:clientes,str_cpf,'.$cliente->id,
            'str_email' => 'required|email|max:120|unique:clientes,str_email,'.$cliente->id,
            'str_telefone' => 'nullable|string|max:20',
            'str_logradouro' => 'nullable|string|max:255',
            'str_numero' => 'nullable|string|max:20',
            'str_bairro' => 'nullable|string|max:100',
            'str_cidade' => 'nullable|string|max:100',
            'str_estado' => 'nullable|string|max:2',
            'empresa_id' => 'required|uuid|exists:empresa,id',
        ]);

        $cliente->update($validated);

        return redirect()->route('pagina.lista.clientes')->with('success', 'Cliente atualizado com sucesso!');
    }

    // Deleta cliente
    public function destroy($id)
    {
        $cliente = Clientes::findOrFail($id);
        $cliente->delete();

        return redirect()->route('pagina.lista.clientes')->with('success', 'Cliente deletado com sucesso!');
    }

}
