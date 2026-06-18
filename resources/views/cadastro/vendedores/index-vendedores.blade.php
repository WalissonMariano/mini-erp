@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Cadastro</p>
                <h1 class="app-header__title">Vendedores</h1>
                <p class="app-header__subtitle">Grade com todos os vendedores cadastrados</p>
            </div>
            <button onclick="loadContent('{{ route('pagina.cadastro.vendedores') }}')" class="app-btn app-btn--primary" type="button" title="Novo vendedor">
                Novo vendedor
            </button>
        </header>

        <div class="app-card">
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th class="col-acoes">Editar</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Empresa</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendedores as $vendedor)
                            <tr>
                                <td class="col-acoes">
                                    <button onclick="loadContent('{{ route('pagina.editar.vendedores', ['id' => $vendedor->id]) }}')" class="app-icon-btn" type="button" title="Editar vendedor">
                                        <x-icon name="heroicon-o-pencil-square" class="app-icon" />
                                    </button>
                                </td>
                                <td>{{ $vendedor->str_nome }}</td>
                                <td>{{ $vendedor->str_cpf }}</td>
                                <td>{{ $vendedor->str_email }}</td>
                                <td>{{ $vendedor->str_telefone ?? '—' }}</td>
                                <td>{{ $vendedor->empresa->str_razao_social ?? '—' }}</td>
                                <td>{{ $vendedor->str_cidade ?? '—' }}</td>
                                <td>{{ $vendedor->str_estado ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr class="app-empty">
                                <td colspan="8">Nenhum vendedor cadastrado.</td>
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
