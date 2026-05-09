<?php

namespace App\Http\Controllers\Estoque;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Estoque\Embalagens;

class EmbalagensController extends Controller
{
    // Busca todas as embalagens
    public function index()
    {
        $embalagens = Embalagens::all();
        return view('estoque/embalagens/index_embalagens', compact('embalagens'));
    }

    // Busca embalagem por id para edição
    public function edit($id)
    {
        $embalagem = Embalagens::findOrFail($id);
        return view('estoque/embalagens/form_embalagens', compact('embalagem'));
    }

    // Formulário de criação de embalagem    
    public function create()
    {
        return view('estoque/embalagens/form_embalagens');
    }

    // Salva dados de uma nova embalagem
    public function store(Request $request)
    {
        $validated = $request->validate([
            'str_sigla' => 'required|string|max:150',
            'str_descricao' => 'nullable|string|max:255',
            'dbl_quantidade_embalagem' => 'required|numeric',
        ]);

        Embalagens::create($validated);

        return redirect()->route('pagina.lista.embalagens')->with('success', 'Embalagem criada com sucesso!');
    }

    // Atualiza os dados da embalagem
    public function update(Request $request, $id)
    {
        $embalagem = Embalagens::findOrFail($id);
        
        $validated = $request->validate([
            'str_sigla' => 'required|string|max:150',
            'str_descricao' => 'nullable|string|max:255',
            'dbl_quantidade_embalagem' => 'required|numeric',
        ]);

        $embalagem->update($validated);

        return redirect()->route('pagina.lista.embalagens')->with('success', 'Embalagem atualizada com sucesso!');
    }

    // Deleta embalagem
    public function destroy($id)
    {
        $embalagem = Embalagens::findOrFail($id);
        $embalagem->delete();

        return redirect()->route('pagina.lista.embalagens')->with('success', 'Embalagem deletada com sucesso!');
    }
}
