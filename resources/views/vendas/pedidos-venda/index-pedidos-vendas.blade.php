@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Vendas</p>
                <h1 class="app-header__title">Pedidos de venda</h1>
                <p class="app-header__subtitle">Grade com todos os pedidos de venda cadastrados</p>
            </div>
            <button onclick="loadContent('{{ route('pagina.novo.pedido_venda') }}')" class="app-btn app-btn--primary" type="button" title="Novo pedido">
                Novo pedido
            </button>
        </header>

        <div class="app-card">
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th class="col-acoes">Editar</th>
                            <th>Número</th>
                            <th>Empresa</th>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th class="col-qtd">Itens</th>
                            <th class="col-valor">Valor total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pedidosVenda as $pedido)
                            <tr>
                                <td class="col-acoes">
                                    <button onclick="loadContent('{{ route('pagina.editar.pedido_venda', ['id' => $pedido->id]) }}')" class="app-icon-btn" type="button" title="Editar pedido">
                                        <x-icon name="heroicon-o-pencil-square" class="app-icon" />
                                    </button>
                                </td>
                                <td>{{ $pedido->numero_pedido ?? '—' }}</td>
                                <td>{{ $pedido->empresa?->str_razao_social ?? '—' }}</td>
                                <td>{{ $pedido->data_pedido?->format('d/m/Y') ?? '—' }}</td>
                                <td>{{ $pedido->cliente?->str_nome ?? '—' }}</td>
                                <td>{{ $pedido->vendedor?->str_nome ?? '—' }}</td>
                                <td class="col-qtd">{{ (int) ($pedido->itens_count ?? 0) }}</td>
                                <td class="col-valor">R$ {{ number_format((float) ($pedido->dbl_valor_total ?? 0), 2, ',', '.') }}</td>
                                <td>
                                    @if ($pedido->status)
                                        @php
                                            $statusClass = match ($pedido->status) {
                                                \App\Models\Venda\PedidosVenda::STATUS_ABERTO => 'app-status--aberto',
                                                \App\Models\Venda\PedidosVenda::STATUS_BAIXADO => 'app-status--baixado',
                                                default => '',
                                            };
                                        @endphp
                                        <span class="app-status {{ $statusClass }}">{{ $pedido->status_label }}</span>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="app-empty">
                                <td colspan="9">Nenhum pedido de venda cadastrado.</td>
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
