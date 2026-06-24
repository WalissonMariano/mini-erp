@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Financeiro</p>
                <h1 class="app-header__title">Contas a receber</h1>
                <p class="app-header__subtitle">Títulos de clientes e demais receitas</p>
            </div>
            <button onclick="loadContent('{{ route('pagina.novo.conta_receber') }}')" class="app-btn app-btn--primary" type="button" title="Nova conta">
                Nova conta
            </button>
        </header>

        <div class="app-card">
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th class="col-acoes">Editar</th>
                            <th>Descrição</th>
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
                                <td class="col-acoes">
                                    <button onclick="loadContent('{{ route('pagina.editar.conta_receber', ['id' => $conta->id]) }}')" class="app-icon-btn" type="button" title="Editar conta">
                                        <x-icon name="heroicon-o-pencil-square" class="app-icon" />
                                    </button>
                                </td>
                                <td>{{ $conta->str_descricao ?: '—' }}</td>
                                <td>{{ $conta->cliente?->str_nome ?? '—' }}</td>
                                <td>{{ $conta->empresa?->str_razao_social ?? '—' }}</td>
                                <td class="col-valor">R$ {{ number_format((float) $conta->dbl_valor, 2, ',', '.') }}</td>
                                <td>{{ $conta->data_vencimento?->format('d/m/Y') ?? '—' }}</td>
                                <td>{{ $conta->data_recebimento?->format('d/m/Y') ?? '—' }}</td>
                                <td>
                                    @php
                                        $st = strtolower((string) $conta->status);
                                        $statusClass = match ($st) {
                                            \App\Models\Financeiro\ContasReceber::STATUS_PAGO => 'pago',
                                            \App\Models\Financeiro\ContasReceber::STATUS_CANCELADO => 'cancelado',
                                            default => 'aberto',
                                        };
                                    @endphp
                                    <span class="app-status app-status--{{ $statusClass }}">{{ $conta->status_label }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr class="app-empty">
                                <td colspan="8">Nenhuma conta a receber cadastrada.</td>
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
