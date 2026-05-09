<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP - Dashboard</title>
    @vite('resources/css/layouts/menu.css')
</head>
<body>
    <!-- Menu Lateral -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>
                <img src="{{ asset('images/logo_azul.png') }}" alt="ERP" class="sidebar-logo"> 
            </h2>
            <button class="toggle-menu-btn" onclick="toggleMenu()">☰</button>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.dashboard.conteudo') }}', this)" class="active">
                        <span>📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="loadContent('#', this)">
                        <span>💰</span>
                        <span>Vendas</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="loadContent('#', this)">
                        <span>🛒</span>
                        <span>Compras</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="loadContent('#', this)">
                        <span>🏦</span>
                        <span>Financeiro</span>
                    </a>
                </li>
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="submenu-toggle" onclick="toggleSubmenu(this)">
                        <span>📦</span>
                        <span>Estoque</span>
                        <span class="submenu-arrow">▾</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('#', this)">
                                <span> </span>
                                <span>Itens</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.embalagens') }}', this)">
                                <span> </span>
                                <span>Embalagens</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.itens_categorias') }}', this)">
                                <span> </span>
                                <span>Categorias</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="submenu-toggle" onclick="toggleSubmenu(this)">
                        <span>🗂️</span>
                        <span>Cadastro</span>
                        <span class="submenu-arrow">▾</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.empresa') }}', this)">
                                <span> </span>
                                <span>Empresa</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.usuarios') }}', this)">
                                <span> </span>
                                <span>Usuarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.grupos') }}', this)">
                                <span> </span>
                                <span>Grupos de Usuários</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.clientes') }}', this)">
                                <span> </span>
                                <span>Clientes</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.vendedores') }}', this)">
                                <span> </span>
                                <span>Vendedores</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
            <p>Sistema ERP v1.0</p>
        </div>
        
        <form method="POST" action="{{ route('pagina.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <span>🚪</span>
                <span>Logout</span>
            </button>
        </form>
    </aside>

    <!-- Conteúdo Principal -->
    <div class="container-main">
        <iframe id="content-frame" class="content-frame" src="{{ route('pagina.dashboard.conteudo') }}"></iframe>
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

        function toggleMenu() {
            const sidebar = document.querySelector('.sidebar');
            const containerMain = document.querySelector('.container-main');
            
            sidebar.classList.toggle('collapsed');
            containerMain.classList.toggle('collapsed');
            
            // Salvar preferência no localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);

            // Aguarda a transição do layout e força resize no iframe.
            setTimeout(refreshIframeLayout, 350);
        }

        function toggleSubmenu(element) {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar.classList.contains('collapsed')) {
                return;
            }

            const menuItem = element.closest('.has-submenu');
            if (!menuItem) {
                return;
            }

            menuItem.classList.toggle('open');
        }

        // Restaurar estado ao carregar página
        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            const iframe = document.getElementById('content-frame');

            if (iframe) {
                iframe.addEventListener('load', function() {
                    setTimeout(refreshIframeLayout, 100);
                });
            }

            if (isCollapsed) {
                const sidebar = document.querySelector('.sidebar');
                const containerMain = document.querySelector('.container-main');
                sidebar.classList.add('collapsed');
                containerMain.classList.add('collapsed');
            }

            setTimeout(refreshIframeLayout, 150);
        });

        function loadContent(url, element) {
            if (url === '#') {
                alert('Esta seção ainda não foi implementada.');
                return;
            }

            // Remove active de todos os links
            document.querySelectorAll('.sidebar nav a').forEach(link => {
                link.classList.remove('active');
            });

            // Mantém submenu pai aberto quando item interno é clicado
            document.querySelectorAll('.has-submenu').forEach(item => {
                if (!item.querySelector('a.active')) {
                    item.classList.remove('open');
                }
            });

            // Adiciona active ao link clicado
            if (element) {
                element.classList.add('active');

                const parentMenu = element.closest('.has-submenu');
                if (parentMenu) {
                    parentMenu.classList.add('open');
                    const toggle = parentMenu.querySelector('.submenu-toggle');
                    if (toggle) {
                        toggle.classList.add('active');
                    }
                }
            }

            // Carrega o conteúdo no iframe
            document.getElementById('content-frame').src = url;

            // Após trocar o conteúdo, garante recalculo de largura interna.
            setTimeout(refreshIframeLayout, 200);
        }

    </script>
</body>
</html>
