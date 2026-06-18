<?php

namespace App\Http\Controllers\Estoque;

use App\Http\Controllers\Controller;
use App\Models\Estoque\Embalagens;
use App\Models\Estoque\Itens;
use App\Models\Estoque\ItensEmbalagem;
use Illuminate\Http\Request;

class ItensEmbalagensController extends Controller
{
    // Busca todos itens embalagens
    public function index()
    {
        $itensEmbalagens = ItensEmbalagem::with('item', 'embalagem')->get();

        return view('estoque/itens-embalagens/index-itens-embalagens', compact('itensEmbalagens'));
    }

    // Busca itens embalagem por id para edição
    public function edit($id)
    {
        $itensEmbalagem = ItensEmbalagem::findOrFail($id);
        $itens = Itens::orderBy('str_descricao')->get();
        $embalagens = Embalagens::orderBy('str_sigla')->get();

        return view('estoque/itens-embalagens/form-itens-embalagens', compact('itensEmbalagem', 'itens', 'embalagens'));
    }

    // Formulário de criação de itens embalagens
    public function create()
    {
        $itens = Itens::orderBy('str_descricao')->get();
        $embalagens = Embalagens::orderBy('str_sigla')->get();

        return view('estoque/itens-embalagens/form-itens-embalagens', compact('itens', 'embalagens'));
    }

    // Salva dados de um novo itens embalagem
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|uuid|exists:itens,id',
            'embalagem_id' => 'required|uuid|exists:embalagens,id',
        ]);

        ItensEmbalagem::create($validated);

        return redirect()->route('pagina.lista.itens_embalagens')->with('success', 'Itens embalagem criado com sucesso!');
    }

    // Atualiza os dados do itens embalagem
    public function update(Request $request, $id)
    {
        $itensEmbalagem = ItensEmbalagem::findOrFail($id);

        $validated = $request->validate([
            'item_id' => 'required|uuid|exists:itens,id',
            'embalagem_id' => 'required|uuid|exists:embalagens,id',
        ], [
            'item_id.required' => 'O item é obrigatório',
            'item_id.uuid' => 'O item deve ser um UUID válido',
            'item_id.exists' => 'O item não existe',
            'embalagem_id.required' => 'A embalagem é obrigatória',
            'embalagem_id.uuid' => 'A embalagem deve ser um UUID válido',
            'embalagem_id.exists' => 'A embalagem não existe',
        ]);

        $itensEmbalagem->update($validated);

        return redirect()->route('pagina.lista.itens_embalagens')->with('success', 'Itens embalagem atualizado com sucesso!');
    }

    // Deleta itens embalagem
    public function destroy($id)
    {
        $itensEmbalagem = ItensEmbalagem::findOrFail($id);
        $itensEmbalagem->delete();

        return redirect()->route('pagina.lista.itens_embalagens')->with('success', 'Itens embalagem deletado com sucesso!');
    }
}
