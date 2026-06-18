<?php

namespace App\Http\Controllers\Cadastro;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Cadastro\Empresa;

class EmpresaController extends Controller
{
    //BUSCA DE TODAS AS EMPRESAS
    public function index()
    {
       $empresas = Empresa::all();
    
       return view('cadastro/empresa/index-empresa', compact('empresas'));
    }

    //BUSCA DE UMA EMPRESA PELO ID PARA EDIÇÃO
    public function edit($id)
    {

       $empresa = Empresa::findOrFail($id);
       return view('cadastro/empresa/form-empresa', compact('empresa'));
        
    }

    //EXIBIÇÃO DO FORMULÁRIO DE CADASTRO DE EMPRESA
    public function create()
    {
        return view('cadastro/empresa/form-empresa');
    }

    //SALVA DADOS DE UMA NOVA EMPRESA
    public function store(Request $request)
    {
        $validated = $request->validate([
            'str_razao_social' => 'required|string|max:150',
            'str_nome_fantasia' => 'nullable|string|max:150',
            'str_cnpj' => 'required|string|unique:empresa|max:18',
            'str_inscricao_estadual' => 'nullable|string|max:30',
            'str_inscricao_municipal' => 'nullable|string|max:30',
            'str_email' => 'nullable|email|max:120',
            'str_telefone' => 'nullable|string|max:20',
            'str_celular' => 'nullable|string|max:20',
            'str_logradouro' => 'nullable|string|max:200',
            'int_numero' => 'nullable|integer',
            'str_complemento' => 'nullable|string|max:120',
            'str_bairro' => 'nullable|string|max:120',
            'str_cidade' => 'nullable|string|max:120',
            'str_estado' => 'nullable|string|max:2',
        ]);

        Empresa::create($validated);

        return redirect()->route('pagina.lista.empresa')->with('success', 'Empresa criada com sucesso!');
    }

    //ATUALIZA UMA EMPRESA PELO ID
    public function update(Request $request, $id)
    {
     
    $validated = $request->validate([
            'str_razao_social' => 'required|string|max:150',
            'str_nome_fantasia' => 'nullable|string|max:150',
            'str_cnpj' => 'required|string|unique:empresa,str_cnpj,' . $id . '|max:18',
            'str_inscricao_estadual' => 'nullable|string|max:30',
            'str_inscricao_municipal' => 'nullable|string|max:30',
            'str_email' => 'nullable|email|max:120',
            'str_telefone' => 'nullable|string|max:20',
            'str_celular' => 'nullable|string|max:20',
            'str_logradouro' => 'nullable|string|max:200',
            'int_numero' => 'nullable|integer',
            'str_complemento' => 'nullable|string|max:120',
            'str_bairro' => 'nullable|string|max:120',
            'str_cidade' => 'nullable|string|max:120',
            'str_estado' => 'nullable|string|max:2',
        ]);

        $empresa = Empresa::findOrFail($id);

        
        $empresa->update($validated);

        return redirect()->route('pagina.lista.empresa')->with('success', 'Empresa atualizada com sucesso!');
    }

    //DELETA UMA EMPRESA PELO ID
    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();

        return redirect()->route('pagina.lista.empresa')->with('success', 'Empresa deletada com sucesso!');
    }

}
