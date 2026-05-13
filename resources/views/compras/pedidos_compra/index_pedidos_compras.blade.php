<div style="padding: 0 20px 20px 20px; background-color: #ffffff; min-height: 100vh; font-family: Arial, sans-serif;">
    <style>
        * { font-family: Arial, sans-serif; }

        .table-wrapper {
            background: white;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .subtitle {
            color: #7f8c8d;
            font-size: 14px;
        }

        .new-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border: none;
            border-radius: 4px;
            background-color: #27ae60;
            color: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .new-btn:hover {
            background-color: #1f8c4d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background-color: #34495e;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
            vertical-align: middle;
        }

        th.col-valor,
        td.col-valor {
            text-align: right;
            white-space: nowrap;
        }

        th.col-qtd,
        td.col-qtd {
            text-align: center;
            white-space: nowrap;
        }

        tbody tr:hover {
            background-color: #f8f9fa;
        }

        .acoes {
            width: 70px;
        }

        .edit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 4px;
            background-color: #3498db;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .edit-btn:hover {
            background-color: #2980b9;
        }

        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            background-color: #eaf7ee;
            color: #1e8449;
        }
    </style>

    <div class="header-bar">
        <div>
            <h2 style="margin: 0 0 4px 0;">Pedidos de compra</h2>
            <div class="subtitle">Grade com todos os pedidos cadastrados (PedidosCompra)</div>
        </div>
        <button onclick="loadContent('{{ route('pagina.novo.pedido_compra') }}')" class="new-btn" type="button" title="Novo pedido">
            + Novo pedido
        </button>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th class="acoes">Editar</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Fornecedor</th>
                    <th>Empresa</th>
                    <th class="col-qtd">Itens</th>
                    <th class="col-valor">Valor total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pedidosCompra as $pedido)
                    <tr>
                        <td>
                            <button onclick="loadContent('{{ route('pagina.editar.pedido_compra', ['id' => $pedido->id]) }}')" class="edit-btn" type="button" title="Editar pedido">
                                ✏️
                            </button>
                        </td>
                        <td>{{ $pedido->data_pedido?->format('d/m/Y') ?? '-' }}</td>
                        <td><span class="status">{{ $pedido->status ?? '-' }}</span></td>
                        <td>{{ $pedido->fornecedor?->str_nome ?? '-' }}</td>
                        <td>{{ $pedido->empresa?->str_razao_social ?? '-' }}</td>
                        <td class="col-qtd">{{ (int) ($pedido->itens_count ?? 0) }}</td>
                        <td class="col-valor">R$ {{ number_format((float) ($pedido->dbl_valor_total ?? 0), 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #7f8c8d;">Nenhum pedido de compra cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>

    function refreshIframeLayout() {
        const iframe = document.getElementById('content-frame');
        if (!iframe || !iframe.contentWindow) {
            return;
        }

        try {
            iframe.contentWindow.dispatchEvent(new Event('resize'));
            iframe.contentWindow.postMessage({ type: 'erp:layout-resize' }, '*');
        } catch (e) {
            // Ignore cross-context resize issues and keep UI functional.
        }
    }

    function loadContent(url) {
        if (url === '#') {
            alert('Esta seção ainda não foi implementada.');
            return;
        }

        window.parent.document.getElementById('content-frame').src = url;

        setTimeout(refreshIframeLayout, 200);
    }

</script>
