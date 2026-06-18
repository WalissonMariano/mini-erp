@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Cadastro</p>
                <h1 class="app-header__title">Grupos de usuários</h1>
                <p class="app-header__subtitle">Grade com todos os grupos cadastrados</p>
            </div>
            <button onclick="loadContent('{{ route('pagina.cadastro.grupos') }}')" class="app-btn app-btn--primary" type="button" title="Novo grupo">
                Novo grupo
            </button>
        </header>

        <div class="app-card">
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th class="col-acoes">Editar</th>
                            <th>Nome</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($grupos as $grupo)
                            <tr>
                                <td class="col-acoes">
                                    <button onclick="loadContent('{{ route('pagina.editar.grupos', ['id' => $grupo->id]) }}')" class="app-icon-btn" type="button" title="Editar grupo">
                                        <x-icon name="heroicon-o-pencil-square" class="app-icon" />
                                    </button>
                                </td>
                                <td>{{ $grupo->str_nome }}</td>
                                <td>
                                    <span class="app-status {{ $grupo->is_active ? 'app-status--active' : 'app-status--inactive' }}">
                                        {{ $grupo->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr class="app-empty">
                                <td colspan="3">Nenhum grupo cadastrado.</td>
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
