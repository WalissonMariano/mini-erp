@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Financeiro</p>
                <h1 class="app-header__title">Contas a pagar</h1>
                <p class="app-header__subtitle">Títulos a fornecedores e demais despesas</p>
            </div>
            <button onclick="loadContent('{{ route('pagina.novo.conta_pagar') }}')" class="app-btn app-btn--primary" type="button" title="Nova conta">
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
                            <th>Fornecedor</th>
                            <th>Empresa</th>
                            <th class="col-valor">Valor</th>
                            <th>Vencimento</th>
                            <th>Pagamento</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contas as $conta)
                            <tr>
                                <td class="col-acoes">
                                    <button onclick="loadContent('{{ route('pagina.editar.conta_pagar', ['id' => $conta->id]) }}')" class="app-icon-btn" type="button" title="Editar conta">
                                        <x-icon name="heroicon-o-pencil-square" class="app-icon" />
                                    </button>
                                </td>
                                <td>{{ $conta->str_descricao ?: '—' }}</td>
                                <td>{{ $conta->fornecedor?->str_nome ?? '—' }}</td>
                                <td>{{ $conta->empresa?->str_razao_social ?? '—' }}</td>
                                <td class="col-valor">R$ {{ number_format((float) $conta->dbl_valor, 2, ',', '.') }}</td>
                                <td>{{ $conta->data_vencimento?->format('d/m/Y') ?? '—' }}</td>
                                <td>{{ $conta->data_pagamento?->format('d/m/Y') ?? '—' }}</td>
                                <td>
                                    @php
                                        $st = strtolower((string) $conta->status);
                                        $statusClass = match ($st) {
                                            \App\Models\Financeiro\ContasPagar::STATUS_PAGO => 'pago',
                                            \App\Models\Financeiro\ContasPagar::STATUS_CANCELADO => 'cancelado',
                                            default => 'aberto',
                                        };
                                    @endphp
                                    <span class="app-status app-status--{{ $statusClass }}">{{ $conta->status_label }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr class="app-empty">
                                <td colspan="8">Nenhuma conta a pagar cadastrada.</td>
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
