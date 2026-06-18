{{-- Partial: tabela de múltiplas linhas (pedidos_vendas_itens) dentro do form do pedido --}}
<div class="app-section-title">Itens do pedido (pedidos_vendas_itens)</div>
<p class="app-repeater__hint">Cada linha é um registro na tabela filha. O valor total da linha é recalculado no servidor (quantidade × valor unitário). Use &quot;Adicionar linha&quot; para incluir mais produtos.</p>

<div class="app-repeater__wrap">
    <table class="app-repeater__table">
        <thead>
            <tr>
                <th>Produto (itens)</th>
                <th class="app-repeater__col-num">Quantidade</th>
                <th class="app-repeater__col-num">Valor unit.</th>
                <th class="app-repeater__col-acoes">Remover</th>
            </tr>
        </thead>
        <tbody id="pv-itens-tbody">
            @foreach ($itensFormRows as $idx => $row)
                <tr class="pv-item-linha">
                    <td>
                        <div class="app-repeater__field">
                            <select name="itens[{{ $idx }}][itens_id]">
                                <option value="" {{ empty($row['itens_id'] ?? null) ? 'selected' : '' }}>Selecione...</option>
                                @foreach ($catalogoItens as $produto)
                                    <option value="{{ $produto->id }}"
                                        {{ (string) ($row['itens_id'] ?? '') === (string) $produto->id ? 'selected' : '' }}>
                                        {{ $produto->str_codigo }} — {{ $produto->str_descricao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td class="app-repeater__col-num">
                        <input type="number" name="itens[{{ $idx }}][dbl_quantidade]" step="0.01" min="0"
                            value="{{ $row['dbl_quantidade'] ?? '' }}" placeholder="0">
                    </td>
                    <td class="app-repeater__col-num">
                        <input type="number" name="itens[{{ $idx }}][dbl_valor_unitario]" step="0.01" min="0"
                            value="{{ $row['dbl_valor_unitario'] ?? '' }}" placeholder="0,00">
                    </td>
                    <td class="app-repeater__col-acoes">
                        <button type="button" class="app-repeater__remove pv-remove-item-row" title="Remover linha">Remover</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<button type="button" class="app-repeater__add" id="pv-add-item-row">+ Adicionar linha</button>

<template id="pv-item-row-template">
    <tr class="pv-item-linha">
        <td>
            <div class="app-repeater__field">
                <select name="itens[][itens_id]">
                    <option value="" selected>Selecione...</option>
                    @foreach ($catalogoItens as $produto)
                        <option value="{{ $produto->id }}">{{ $produto->str_codigo }} — {{ $produto->str_descricao }}</option>
                    @endforeach
                </select>
            </div>
        </td>
        <td class="app-repeater__col-num">
            <input type="number" name="itens[][dbl_quantidade]" step="0.01" min="0" value="" placeholder="0">
        </td>
        <td class="app-repeater__col-num">
            <input type="number" name="itens[][dbl_valor_unitario]" step="0.01" min="0" value="" placeholder="0,00">
        </td>
        <td class="app-repeater__col-acoes">
            <button type="button" class="app-repeater__remove pv-remove-item-row" title="Remover linha">Remover</button>
        </td>
    </tr>
</template>
