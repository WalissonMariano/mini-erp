@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Estoque</p>
                <h1 class="app-header__title">Itens</h1>
                <p class="app-header__subtitle">Grade com todos os itens cadastrados</p>
            </div>
            <button onclick="loadContent('{{ route('pagina.cadastro.itens') }}')" class="app-btn app-btn--primary" type="button" title="Novo item">
                Novo item
            </button>
        </header>

        <div class="app-card">
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th class="col-acoes">Editar</th>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th class="col-preco">Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($itens as $item)
                            <tr>
                                <td class="col-acoes">
                                    <button onclick="loadContent('{{ route('pagina.editar.itens', ['id' => $item->id]) }}')" class="app-icon-btn" type="button" title="Editar item">
                                        <x-icon name="heroicon-o-pencil-square" class="app-icon" />
                                    </button>
                                </td>
                                <td>{{ $item->str_codigo }}</td>
                                <td>{{ $item->str_descricao }}</td>
                                <td>{{ $item->categoria?->str_descricao ?? '—' }}</td>
                                <td class="col-preco">R$ {{ number_format((float) $item->dbl_preco, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr class="app-empty">
                                <td colspan="5">Nenhum item cadastrado.</td>
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
