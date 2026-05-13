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

        .subtitle { color: #7f8c8d; font-size: 14px; }

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

        .new-btn:hover { background-color: #1f8c4d; }

        table { width: 100%; border-collapse: collapse; }

        thead tr { background-color: #34495e; color: white; }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
            vertical-align: middle;
        }

        th.col-valor, td.col-valor { text-align: right; white-space: nowrap; }

        tbody tr:hover { background-color: #f8f9fa; }

        .acoes { width: 70px; }

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

        .edit-btn:hover { background-color: #2980b9; }

        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-aberto { background-color: #fef9e7; color: #9a7b0a; }
        .status-pago { background-color: #eaf7ee; color: #1e8449; }
        .status-cancelado { background-color: #fdecea; color: #a94442; }

        .alert-success {
            margin-bottom: 16px;
            padding: 10px 12px;
            border-radius: 4px;
            font-size: 14px;
            border: 1px solid #c3e6cb;
            background: #d4edda;
            color: #155724;
        }
    </style>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="header-bar">
        <div>
            <h2 style="margin: 0 0 4px 0;">Contas a receber</h2>
            <div class="subtitle">Titulos de clientes e demais receitas (contas_receber)</div>
        </div>
        <button onclick="loadContent('{{ route('pagina.novo.conta_receber') }}')" class="new-btn" type="button" title="Nova conta">
            + Nova conta
        </button>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th class="acoes">Editar</th>
                    <th>Descricao</th>
                    <th>Cliente</th>
                    <th>Empresa</th>
                    <th class="col-valor">Valor</th>
                    <th>Vencimento</th>
                    <th>Recebimento</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contas as $conta)
                    <tr>
                        <td>
                            <button onclick="loadContent('{{ route('pagina.editar.conta_receber', ['id' => $conta->id]) }}')" class="edit-btn" type="button" title="Editar">✏️</button>
                        </td>
                        <td>{{ $conta->str_descricao ?: '-' }}</td>
                        <td>{{ $conta->cliente?->str_nome ?? '-' }}</td>
                        <td>{{ $conta->empresa?->str_razao_social ?? '-' }}</td>
                        <td class="col-valor">R$ {{ number_format((float) $conta->dbl_valor, 2, ',', '.') }}</td>
                        <td>{{ $conta->data_vencimento?->format('d/m/Y') ?? '-' }}</td>
                        <td>{{ $conta->data_recebimento?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            @php $st = strtolower((string) $conta->status); @endphp
                            <span class="status status-{{ $st === 'pago' ? 'pago' : ($st === 'cancelado' ? 'cancelado' : 'aberto') }}">{{ $conta->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #7f8c8d;">Nenhuma conta a receber cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
    function refreshIframeLayout() {
        const iframe = document.getElementById('content-frame');
        if (!iframe || !iframe.contentWindow) return;
        try {
            iframe.contentWindow.dispatchEvent(new Event('resize'));
            iframe.contentWindow.postMessage({ type: 'erp:layout-resize' }, '*');
        } catch (e) {}
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
