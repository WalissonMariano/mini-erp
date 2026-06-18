@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Compras</p>
                <h1 class="app-header__title">Pedidos de compra</h1>
                <p class="app-header__subtitle">Grade com todos os pedidos de compra cadastrados</p>
            </div>
            <button onclick="loadContent('{{ route('pagina.novo.pedido_compra') }}')" class="app-btn app-btn--primary" type="button" title="Novo pedido">
                Novo pedido
            </button>
        </header>

        <div class="app-card">
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th class="col-acoes">Editar</th>
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
                                <td class="col-acoes">
                                    <button onclick="loadContent('{{ route('pagina.editar.pedido_compra', ['id' => $pedido->id]) }}')" class="app-icon-btn" type="button" title="Editar pedido">
                                        <x-icon name="heroicon-o-pencil-square" class="app-icon" />
                                    </button>
                                </td>
                                <td>{{ $pedido->data_pedido?->format('d/m/Y') ?? '—' }}</td>
                                <td>
                                    @if ($pedido->status)
                                        <span class="app-status">{{ $pedido->status }}</span>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $pedido->fornecedor?->str_nome ?? '—' }}</td>
                                <td>{{ $pedido->empresa?->str_razao_social ?? '—' }}</td>
                                <td class="col-qtd">{{ (int) ($pedido->itens_count ?? 0) }}</td>
                                <td class="col-valor">R$ {{ number_format((float) ($pedido->dbl_valor_total ?? 0), 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr class="app-empty">
                                <td colspan="7">Nenhum pedido de compra cadastrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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
