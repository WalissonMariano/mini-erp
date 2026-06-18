@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Estoque</p>
                <h1 class="app-header__title">Categorias de itens</h1>
                <p class="app-header__subtitle">Grade com todas as categorias cadastradas</p>
            </div>
            <button onclick="loadContent('{{ route('pagina.cadastro.itens_categorias') }}')" class="app-btn app-btn--primary" type="button" title="Nova categoria">
                Nova categoria
            </button>
        </header>

        <div class="app-card">
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th class="col-acoes">Editar</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($itensCategorias as $categoria)
                            <tr>
                                <td class="col-acoes">
                                    <button onclick="loadContent('{{ route('pagina.editar.itens_categorias', ['id' => $categoria->id]) }}')" class="app-icon-btn" type="button" title="Editar categoria">
                                        <x-icon name="heroicon-o-pencil-square" class="app-icon" />
                                    </button>
                                </td>
                                <td>{{ $categoria->str_descricao }}</td>
                            </tr>
                        @empty
                            <tr class="app-empty">
                                <td colspan="2">Nenhuma categoria cadastrada.</td>
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
