{{-- Partial: tabela de múltiplas linhas (pedidos_vendas_itens) dentro do form do pedido --}}
<style>
    .pv-itens-wrap {
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid #ecf0f1;
        margin-bottom: 12px;
    }

    .pv-itens-table {
        width: 100%;
        border-collapse: collapse;
    }

    .pv-itens-table thead tr {
        background-color: #34495e;
        color: white;
    }

    .pv-itens-table th,
    .pv-itens-table td {
        padding: 10px 12px;
        text-align: left;
        border-bottom: 1px solid #ecf0f1;
        vertical-align: middle;
    }

    .pv-itens-table th.col-num,
    .pv-itens-table td.col-num {
        text-align: right;
        white-space: nowrap;
        width: 120px;
    }

    .pv-itens-table th.col-acoes {
        width: 90px;
        text-align: center;
    }

    .pv-itens-table td .field {
        margin: 0;
    }

    .pv-itens-table select,
    .pv-itens-table input {
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

    .pv-itens-hint {
        font-size: 13px;
        color: #7f8c8d;
        margin: 0 0 10px 0;
        line-height: 1.4;
    }
</style>

<div class="section-title">Itens do pedido (pedidos_vendas_itens)</div>
<p class="pv-itens-hint">Cada linha é um registro na tabela filha. O valor total da linha é recalculado no servidor (quantidade × valor unitário). Use &quot;Adicionar linha&quot; para incluir mais produtos.</p>

<div class="pv-itens-wrap">
    <table class="pv-itens-table">
        <thead>
            <tr>
                <th>Produto (itens)</th>
                <th class="col-num">Quantidade</th>
                <th class="col-num">Valor unit.</th>
                <th class="col-acoes">Remover</th>
            </tr>
        </thead>
        <tbody id="pv-itens-tbody">
            @foreach ($itensFormRows as $idx => $row)
                <tr class="pv-item-linha">
                    <td>
                        <div class="field">
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
                    <td class="col-num">
                        <input type="number" name="itens[{{ $idx }}][dbl_quantidade]" step="0.01" min="0"
                            value="{{ $row['dbl_quantidade'] ?? '' }}" placeholder="0">
                    </td>
                    <td class="col-num">
                        <input type="number" name="itens[{{ $idx }}][dbl_valor_unitario]" step="0.01" min="0"
                            value="{{ $row['dbl_valor_unitario'] ?? '' }}" placeholder="0,00">
                    </td>
                    <td class="col-acoes" style="text-align:center;">
                        <button type="button" class="btn-remover-linha pv-remove-item-row" title="Remover linha">Remover</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<button type="button" class="btn-add-linha" id="pv-add-item-row">+ Adicionar linha</button>

<template id="pv-item-row-template">
    <tr class="pv-item-linha">
        <td>
            <div class="field">
                <select name="itens[][itens_id]">
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
            <button type="button" class="btn-remover-linha pv-remove-item-row" title="Remover linha">Remover</button>
        </td>
    </tr>
</template>
