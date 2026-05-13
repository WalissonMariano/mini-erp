<?php

namespace App\Http\Controllers\Estoque;

use App\Http\Controllers\Controller;
use App\Models\Estoque\Embalagens;
use App\Models\Estoque\Itens;
use App\Models\Estoque\ItensCategorias;
use App\Models\Estoque\ItensEmbalagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ItensController extends Controller
{
    // Busca todos itens
    public function index()
    {
        $itens = Itens::with('categoria')
            ->orderBy('str_descricao')
            ->get();

        return view('estoque/itens/index_itens', compact('itens'));
    }

    // Busca item por id para edição
    public function edit($id)
    {
        $item = Itens::with('itensEmbalagens')->findOrFail($id);
        $categorias = ItensCategorias::orderBy('str_descricao')->get();
        $embalagens = Embalagens::orderBy('str_sigla')->get();
        $embalagensSelecionadas = $item->itensEmbalagens->pluck('embalagem_id')->all();

        return view('estoque/itens/form_itens', compact('item', 'categorias', 'embalagens', 'embalagensSelecionadas'));
    }

    // Formulário de criação de item
    public function create()
    {
        $categorias = ItensCategorias::orderBy('str_descricao')->get();
        $embalagens = Embalagens::orderBy('str_sigla')->get();

        return view('estoque/itens/form_itens', [
            'categorias' => $categorias,
            'item' => null,
            'embalagens' => $embalagens,
            'embalagensSelecionadas' => [],
        ]);
    }

    // Salva dados de um novo item
    public function store(Request $request)
    {
        $this->normalizarEmbalagemIdsNaRequest($request);

        $validated = $request->validate([
            'str_codigo' => 'required|string|max:50|unique:itens,str_codigo',
            'str_descricao' => 'required|string|max:150',
            'dbl_preco' => 'required|numeric|min:0',
            'categoria_id' => 'required|uuid|exists:itens_categorias,id',
            'embalagem_ids' => ['nullable', 'array', 'distinct'],
            'embalagem_ids.*' => 'uuid|exists:embalagens,id',
        ]);

        $embalagemIds = $validated['embalagem_ids'] ?? [];
        unset($validated['embalagem_ids']);

        DB::transaction(function () use ($validated, $embalagemIds) {
            $item = Itens::create($validated);
            $this->syncItemEmbalagens($item, $embalagemIds);
        });

        return redirect()->route('pagina.lista.itens')->with('success', 'Item criado com sucesso!');
    }

    // Atualiza os dados do item
    public function update(Request $request, $id)
    {
        $item = Itens::findOrFail($id);

        $this->normalizarEmbalagemIdsNaRequest($request);

        $validated = $request->validate([
            'str_codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('itens', 'str_codigo')->ignore($item->id),
            ],
            'str_descricao' => 'required|string|max:150',
            'dbl_preco' => 'required|numeric|min:0',
            'categoria_id' => 'required|uuid|exists:itens_categorias,id',
            'embalagem_ids' => ['nullable', 'array', 'distinct'],
            'embalagem_ids.*' => 'uuid|exists:embalagens,id',
        ]);

        $embalagemIds = $validated['embalagem_ids'] ?? [];
        unset($validated['embalagem_ids']);

        DB::transaction(function () use ($item, $validated, $embalagemIds) {
            $item->update($validated);
            $this->syncItemEmbalagens($item, $embalagemIds);
        });

        return redirect()->route('pagina.lista.itens')->with('success', 'Item atualizado com sucesso!');
    }

    // Deleta item
    public function destroy($id)
    {
        $item = Itens::findOrFail($id);
        $item->itensEmbalagens()->delete();
        $item->delete();

        return redirect()->route('pagina.lista.itens')->with('success', 'Item deletado com sucesso!');
    }

    /**
     * @param  array<int|string|null>  $embalagemIds
     */
    private function syncItemEmbalagens(Itens $item, array $embalagemIds): void
    {
        $ids = array_values(array_filter($embalagemIds, fn ($id) => $id !== null && $id !== ''));
        $item->itensEmbalagens()->delete();
        foreach ($ids as $embalagemId) {
            ItensEmbalagem::create([
                'item_id' => $item->id,
                'embalagem_id' => $embalagemId,
            ]);
        }
    }

    private function normalizarEmbalagemIdsNaRequest(Request $request): void
    {
        $raw = $request->input('embalagem_ids');
        if (! is_array($raw)) {
            $request->merge(['embalagem_ids' => []]);

            return;
        }

        $filtrado = array_values(array_filter($raw, fn ($v) => $v !== null && $v !== ''));
        $request->merge(['embalagem_ids' => $filtrado]);
    }
}
