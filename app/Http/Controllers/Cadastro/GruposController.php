<?php

namespace App\Http\Controllers\Cadastro;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Cadastro\Grupos;

class GruposController extends Controller
{
    //Busca de todos os grupos
    public function index()
    {
        $grupos = Grupos::all();
        return view('cadastro/grupos/index_grupos', compact('grupos'));
    }
    
    //Busca de um grupo pelo ID para edição
    public function edit($id)
    {
        $grupo = Grupos::findOrFail($id);
        return view('cadastro/grupos/form_grupos', compact('grupo'));
    }

    //Exibição do formulário de cadastro de grupo
    public function create()
    {
        return view('cadastro/grupos/form_grupos');
    }

    //Salva dados de um novo grupo
    public function store(Request $request)
    {
        $validated = $request->validate([
            'str_nome' => 'required|string|max:150',
        ]);
        Grupos::create($validated);
        return redirect()->route('pagina.lista.grupos')->with('success', 'Grupo criado com sucesso!');
    }

    //Atualiza um grupo pelo ID
    public function update(Request $request, $id)
    {        
        $validated = $request->validate([
            'str_nome' => 'required|string|max:150',
        ]);
        $grupo = Grupos::findOrFail($id);
        $grupo->update($validated);
        return redirect()->route('pagina.lista.grupos')->with('success', 'Grupo atualizado com sucesso!');
    }   

    //Exclui um grupo pelo ID
    public function destroy($id)
    {        
        $grupo = Grupos::findOrFail($id);
        $grupo->delete();
        return redirect()->route('pagina.lista.grupos')->with('success', 'Grupo excluído com sucesso!');
    }


}
