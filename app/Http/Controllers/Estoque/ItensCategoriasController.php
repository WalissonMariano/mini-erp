<?php

namespace App\Http\Controllers\Estoque;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Estoque\ItensCategorias;

class ItensCategoriasController extends Controller
{
    // Busca todas as categorias de itens
    public function index()
    {
        $itensCategorias = ItensCategorias::all();
        return view('estoque/itens-categorias/index-itens-categorias', compact('itensCategorias'));
    }

    // Busca categoria por id para edição
    public function edit($id)
    {
        $itensCategorias = ItensCategorias::findOrFail($id);
        return view('estoque/itens-categorias/form-itens-categorias', compact('itensCategorias'));
    }

    // Formulário de criação de categoria    
    public function create()
    {
        return view('estoque/itens-categorias/form-itens-categorias');
    }

    // Salva dados de uma nova categoria
    public function store(Request $request)
    {
        $validated = $request->validate([
            'str_descricao' => 'required|string|max:50',
        ]);

        ItensCategorias::create($validated);

        return redirect()->route('pagina.lista.itens_categorias')->with('success', 'Categoria criada com sucesso!');
    }

    // Atualiza os dados da categoria
    public function update(Request $request, $id)
    {
        $itensCategorias = ItensCategorias::findOrFail($id);
        
        $validated = $request->validate([
            'str_descricao' => 'required|string|max:50',
        ]);

        $itensCategorias->update($validated);

        return redirect()->route('pagina.lista.itens_categorias')->with('success', 'Categoria atualizada com sucesso!');
    }

    // Deleta categoria
    public function destroy($id)
    {
        $itensCategorias = ItensCategorias::findOrFail($id);
        $itensCategorias->delete();

        return redirect()->route('pagina.lista.itens_categorias')->with('success', 'Categoria deletada com sucesso!');
    }
}

