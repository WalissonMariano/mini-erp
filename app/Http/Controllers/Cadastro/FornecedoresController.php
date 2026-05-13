<?php

namespace App\Http\Controllers\Cadastro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cadastro\Fornecedores;
use App\Models\Cadastro\Empresa;
use Illuminate\Validation\Rule;

class FornecedoresController extends Controller
{
    //Busca todos fornecedores
    public function index()
    {
        $fornecedores = Fornecedores::with('empresa')->orderBy('str_nome')->get();
        return view('cadastro/fornecedores/index_fornecedores', compact('fornecedores'));
    }

    //Busca fornecedor por id para edição
    public function edit($id)
    {
        $fornecedor = Fornecedores::findOrFail($id);
        $empresas = Empresa::orderBy('str_razao_social')->get();

        return view('cadastro/fornecedores/form_fornecedores', compact('fornecedor', 'empresas'));
    }
    
    //Formulário de criação de fornecedor
    public function create()
    {
        $empresas = Empresa::orderBy('str_razao_social')->get();

        return view('cadastro/fornecedores/form_fornecedores', [
            'empresas' => $empresas,
            'fornecedor' => null,
        ]);
    }
    
    //Salva dados de um novo fornecedor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'str_nome' => 'required|string|max:150',
            'str_cpf' => 'required|string|unique:fornecedores|max:14',
            'str_email' => 'required|email|unique:fornecedores|max:120',
            'str_telefone' => 'nullable|string|max:20',
            'str_logradouro' => 'nullable|string|max:255',
            'str_numero' => 'nullable|string|max:10',
            'str_bairro' => 'nullable|string|max:100',
            'str_cidade' => 'nullable|string|max:100',
            'str_estado' => 'nullable|string|max:2',
            'empresa_id' => 'required|uuid|exists:empresa,id',
        ]);
        Fornecedores::create($validated);
        return redirect()->route('pagina.lista.fornecedores')->with('success', 'Fornecedor criado com sucesso!');
    }

    //Atualiza os dados de um fornecedor
    public function update(Request $request, $id)
    {
        $fornecedor = Fornecedores::findOrFail($id);

        $validated = $request->validate([
            'str_nome' => 'required|string|max:150',
            'str_cpf' => [
                'required',
                'string',
                'max:14',
                Rule::unique('fornecedores', 'str_cpf')->ignore($fornecedor->id),
            ],
            'str_email' => [
                'required',
                'email',
                'max:120',
                Rule::unique('fornecedores', 'str_email')->ignore($fornecedor->id),
            ],
            'str_telefone' => 'nullable|string|max:20',
            'str_logradouro' => 'nullable|string|max:255',
            'str_numero' => 'nullable|string|max:10',
            'str_bairro' => 'nullable|string|max:100',
            'str_cidade' => 'nullable|string|max:100',
            'str_estado' => 'nullable|string|max:2',
            'empresa_id' => 'required|uuid|exists:empresa,id',
        ]);

        $fornecedor->update($validated);

        return redirect()->route('pagina.lista.fornecedores')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    //Deleta um fornecedor
    public function destroy($id)
    {
        $fornecedor = Fornecedores::findOrFail($id);
        $fornecedor->delete();
        return redirect()->route('pagina.lista.fornecedores')->with('success', 'Fornecedor deletado com sucesso!');
    }

}
