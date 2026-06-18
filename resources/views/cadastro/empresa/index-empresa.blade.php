@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
    <header class="app-header">
        <div class="app-header__text">
            <p class="app-header__eyebrow">Cadastro</p>
            <h1 class="app-header__title">Empresas</h1>
            <p class="app-header__subtitle">Grade com todas as empresas cadastradas</p>
        </div>
        <button onclick="loadContent('{{ route('pagina.cadastro.empresa') }}')" class="app-btn app-btn--primary" type="button" title="Nova empresa">
            Nova empresa
        </button>
    </header>

    <div class="app-card">
        <div class="app-table-wrap">
            <table class="app-table">
                <thead>
                    <tr>
                        <th class="col-acoes">Editar</th>
                        <th>Razão social</th>
                        <th>Nome fantasia</th>
                        <th>CNPJ</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Cidade</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empresas as $empresa)
                        <tr>
                            <td class="col-acoes">
                                <button onclick="loadContent('{{ route('pagina.editar.empresa', ['id' => $empresa->id]) }}')" class="app-icon-btn" type="button" title="Editar empresa">
                                    <x-icon name="heroicon-o-pencil-square" class="app-icon" />
                                </button>
                            </td>
                            <td>{{ $empresa->str_razao_social }}</td>
                            <td>{{ $empresa->str_nome_fantasia }}</td>
                            <td>{{ $empresa->str_cnpj }}</td>
                            <td>{{ $empresa->str_email }}</td>
                            <td>{{ $empresa->str_telefone }}</td>
                            <td>{{ $empresa->str_cidade }}</td>
                            <td>
                                <span class="app-status {{ $empresa->status ? 'app-status--active' : 'app-status--inactive' }}">
                                    {{ $empresa->status ? 'Ativa' : 'Inativa' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
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
