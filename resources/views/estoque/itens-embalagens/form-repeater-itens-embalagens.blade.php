{{-- Partial: tabela de múltiplas linhas (itens_embalagens) dentro do form do item --}}
@php
    $embalagens = $embalagens ?? collect();
    $linhasEmbalagem = old('embalagem_ids');
    if ($linhasEmbalagem === null) {
        $linhasEmbalagem = $embalagensSelecionadas ?? [];
    }
    if (! is_array($linhasEmbalagem)) {
        $linhasEmbalagem = [];
    }
    if (count($linhasEmbalagem) === 0 && $embalagens->isNotEmpty()) {
        $linhasEmbalagem = [''];
    }
@endphp

<div class="app-section-title">Embalagens do item</div>

@if ($embalagens->isEmpty())
    <p class="app-repeater__hint app-repeater__hint--flush">Nenhuma embalagem cadastrada. Cadastre embalagens no menu Estoque antes de vincular aqui.</p>
@else
    <div class="app-repeater__wrap">
        <table class="app-repeater__table">
            <thead>
                <tr>
                    <th class="app-repeater__col-idx">#</th>
                    <th>Embalagem</th>
                    <th class="app-repeater__col-acoes">Ações</th>
                </tr>
            </thead>
            <tbody id="embalagem-tbody">
                @foreach ($linhasEmbalagem as $idx => $valorLinha)
                    <tr class="embalagem-linha">
                        <td class="app-repeater__col-idx embalagem-idx">{{ $loop->iteration }}</td>
                        <td>
                            <div class="app-repeater__field">
                                <select name="embalagem_ids[]" aria-label="Embalagem {{ $loop->iteration }}">
                                    <option value="" {{ (string) $valorLinha === '' ? 'selected' : '' }}>Selecione…</option>
                                    @foreach ($embalagens as $embalagem)
                                        <option value="{{ $embalagem->id }}"
                                            {{ (string) $valorLinha !== '' && (string) $valorLinha === (string) $embalagem->id ? 'selected' : '' }}>
                                            {{ $embalagem->str_sigla }} — {{ $embalagem->str_descricao }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td class="app-repeater__col-acoes">
                            <button type="button" class="app-repeater__remove embalagem-remover-linha" title="Remover embalagem" aria-label="Remover embalagem">
                                <x-icon name="heroicon-o-trash" class="app-icon" />
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <button type="button" class="app-repeater__add" id="embalagem-add-linha">Incluir Embalagem</button>
@endif
