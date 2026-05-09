<?php

namespace App\Http\Controllers\Estoque;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ItensController extends Controller
{
        // Busca todos vendedores
    public function index()
    {
        $vendedores = Vendedores::with('empresa')->orderBy('str_nome')->get();
        return view('vendedores/index_vendedores', compact('vendedores'));
    }

    // Busca vendedor por id para edição
    public function edit($id)
    {
        $vendedor = Vendedores::findOrFail($id);
        $empresa = Empresa::findOrFail($vendedor->empresa_id);
        return view('cadastro/vendedores/form_vendedores', compact('vendedor', 'empresa'));
    }

    // Formulário de criação de vendedor    
    public function create()
    {
        $empresas = Empresa::all();
        return view('cadastro/vendedores/form_vendedores', compact('empresas'));
    }

    // Salva dados de um novo vendedor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'str_nome' => 'required|string|max:150',
            'str_cpf' => 'required|string|unique:vendedores|max:14',
            'str_email' => 'required|email|unique:vendedores|max:120',
            'str_telefone' => 'nullable|string|max:20',
            'str_logradouro' => 'nullable|string|max:255',
            'str_numero' => 'nullable|string|max:20',
            'str_bairro' => 'nullable|string|max:100',
            'str_cidade' => 'nullable|string|max:100',
            'str_estado' => 'nullable|string|max:2',
            'empresa_id' => 'required|uuid|exists:empresa,id',
        ]);

        Vendedores::create($validated);

        return redirect()->route('pagina.lista.vendedores')->with('success', 'Vendedor criado com sucesso!');
    }

    // Atualiza os dados do vendedor
    public function update(Request $request, $id)
    {
        $vendedor = Vendedores::findOrFail($id);
        
        $validated = $request->validate([
            'str_nome' => 'required|string|max:150',
            'str_cpf' => 'required|string|max:14|unique:vendedores,str_cpf,'.$vendedor->id,
            'str_email' => 'required|email|max:120|unique:vendedores,str_email,'.$vendedor->id,
            'str_telefone' => 'nullable|string|max:20',
            'str_logradouro' => 'nullable|string|max:255',
            'str_numero' => 'nullable|string|max:20',
            'str_bairro' => 'nullable|string|max:100',
            'str_cidade' => 'nullable|string|max:100',
            'str_estado' => 'nullable|string|max:2',
            'empresa_id' => 'required|uuid|exists:empresa,id',
        ]);

        $vendedor->update($validated);

        return redirect()->route('pagina.lista.vendedores')->with('success', 'Vendedor atualizado com sucesso!');
    }

    // Deleta vendedor
    public function destroy($id)
    {
        $vendedor = Vendedores::findOrFail($id);
        $vendedor->delete();

        return redirect()->route('pagina.lista.vendedores')->with('success', 'Vendedor deletado com sucesso!');
    }
}
