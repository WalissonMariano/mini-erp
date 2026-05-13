{{-- Partial: tabela de múltiplas linhas (pedidos_compras_itens) dentro do form do pedido --}}
<style>
    .pc-itens-wrap {
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid #ecf0f1;
        margin-bottom: 12px;
    }

    .pc-itens-table {
        width: 100%;
        border-collapse: collapse;
    }

    .pc-itens-table thead tr {
        background-color: #34495e;
        color: white;
    }

    .pc-itens-table th,
    .pc-itens-table td {
        padding: 10px 12px;
        text-align: left;
        border-bottom: 1px solid #ecf0f1;
        vertical-align: middle;
    }

    .pc-itens-table th.col-num,
    .pc-itens-table td.col-num {
        text-align: right;
        white-space: nowrap;
        width: 120px;
    }

    .pc-itens-table th.col-acoes {
        width: 90px;
        text-align: center;
    }

    .pc-itens-table td .field {
        margin: 0;
    }

    .pc-itens-table select,
    .pc-itens-table input {
        width: 100%;
        font-size: 14px;
        padding: 6px 8px;
        border-radius: 4px;
        border: 1px solid #d9dee3;
        box-sizing: border-box;
        min-height: 34px;
    }

    .btn-remover-linha {
        padding: 6px 10px;
        border: none;
        border-radius: 4px;
        background-color: #e74c3c;
        color: white;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
    }

    .btn-remover-linha:hover {
        background-color: #c0392b;
    }

    .btn-add-linha {
        margin-top: 8px;
        padding: 8px 14px;
        border: none;
        border-radius: 4px;
        background-color: #27ae60;
        color: white;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
    }

    .btn-add-linha:hover {
        background-color: #1f8c4d;
    }

    .pc-itens-hint {
        font-size: 13px;
        color: #7f8c8d;
        margin: 0 0 10px 0;
        line-height: 1.4;
    }
</style>

<div class="section-title">Itens do pedido (pedidos_compras_itens)</div>
<p class="pc-itens-hint">Cada linha é um registro na tabela filha. O valor total da linha é recalculado no servidor (quantidade × valor unitário). Use &quot;Adicionar linha&quot; para incluir mais produtos.</p>

<div class="pc-itens-wrap">
    <table class="pc-itens-table">
        <thead>
            <tr>
                <th>Produto (itens)</th>
                <th class="col-num">Quantidade</th>
                <th class="col-num">Valor unit.</th>
                <th class="col-acoes">Remover</th>
            </tr>
        </thead>
        <tbody id="pc-itens-tbody">
            @foreach ($itensFormRows as $idx => $row)
                <tr class="pc-item-linha">
                    <td>
                        <div class="field">
                            <select name="itens[{{ $idx }}][item_id]">
                                <option value="" {{ empty($row['item_id'] ?? null) ? 'selected' : '' }}>Selecione...</option>
                                @foreach ($catalogoItens as $produto)
                                    <option value="{{ $produto->id }}"
                                        {{ (string) ($row['item_id'] ?? '') === (string) $produto->id ? 'selected' : '' }}>
                                        {{ $produto->str_codigo }} — {{ $produto->str_descricao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td class="col-num">
                        <input type="number" name="itens[{{ $idx }}][dbl_quantidade]" step="0.01" min="0"
                            value="{{ $row['dbl_quantidade'] ?? '' }}" placeholder="0">
                    </td>
                    <td class="col-num">
                        <input type="number" name="itens[{{ $idx }}][dbl_valor_unitario]" step="0.01" min="0"
                            value="{{ $row['dbl_valor_unitario'] ?? '' }}" placeholder="0,00">
                    </td>
                    <td class="col-acoes" style="text-align:center;">
                        <button type="button" class="btn-remover-linha pc-remove-item-row" title="Remover linha">Remover</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<button type="button" class="btn-add-linha" id="pc-add-item-row">+ Adicionar linha</button>

<template id="pc-item-row-template">
    <tr class="pc-item-linha">
        <td>
            <div class="field">
                <select name="itens[][item_id]">
                    <option value="" selected>Selecione...</option>
                    @foreach ($catalogoItens as $produto)
                        <option value="{{ $produto->id }}">{{ $produto->str_codigo }} — {{ $produto->str_descricao }}</option>
                    @endforeach
                </select>
            </div>
        </td>
        <td class="col-num">
            <input type="number" name="itens[][dbl_quantidade]" step="0.01" min="0" value="" placeholder="0">
        </td>
        <td class="col-num">
            <input type="number" name="itens[][dbl_valor_unitario]" step="0.01" min="0" value="" placeholder="0,00">
        </td>
        <td class="col-acoes" style="text-align:center;">
            <button type="button" class="btn-remover-linha pc-remove-item-row" title="Remover linha">Remover</button>
        </td>
    </tr>
</template>
