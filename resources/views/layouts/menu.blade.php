<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP — Painel</title>
    @vite('resources/css/layouts/menu.css')
</head>
<body>
    <!-- Menu Lateral -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>
                <img src="{{ asset('images/logo_azul.png') }}" alt="ERP" class="sidebar-logo"> 
            </h2>
            <button type="button" class="toggle-menu-btn" onclick="toggleMenu()" title="Recolher menu" aria-label="Recolher menu">
                <x-icon name="heroicon-o-bars-3" class="nav-icon nav-icon--toggle" />
            </button>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.dashboard.conteudo') }}', this)" class="active">
                        <x-icon name="heroicon-o-chart-pie" class="nav-icon" />
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.pedidos_venda') }}', this)">
                        <x-icon name="heroicon-o-currency-dollar" class="nav-icon" />
                        <span>Vendas</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.pedidos_compra') }}', this)">
                        <x-icon name="heroicon-o-shopping-cart" class="nav-icon" />
                        <span>Compras</span>
                    </a>
                </li>
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="submenu-toggle" onclick="toggleSubmenu(this)">
                        <x-icon name="heroicon-o-building-library" class="nav-icon" />
                        <span>Financeiro</span>
                        <span class="submenu-arrow">▾</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.contas_pagar') }}', this)">
                                <x-icon name="heroicon-o-arrow-trending-down" class="nav-icon nav-icon--sm" />
                                <span>Contas a pagar</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.contas_receber') }}', this)">
                                <x-icon name="heroicon-o-arrow-trending-up" class="nav-icon nav-icon--sm" />
                                <span>Contas a receber</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="submenu-toggle" onclick="toggleSubmenu(this)">
                        <x-icon name="heroicon-o-cube" class="nav-icon" />
                        <span>Estoque</span>
                        <span class="submenu-arrow">▾</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.itens') }}', this)">
                                <x-icon name="heroicon-o-clipboard-document-list" class="nav-icon nav-icon--sm" />
                                <span>Itens</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.embalagens') }}', this)">
                                <x-icon name="heroicon-o-archive-box" class="nav-icon nav-icon--sm" />
                                <span>Embalagens</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.itens_categorias') }}', this)">
                                <x-icon name="heroicon-o-tag" class="nav-icon nav-icon--sm" />
                                <span>Categorias</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="submenu-toggle" onclick="toggleSubmenu(this)">
                        <x-icon name="heroicon-o-folder-open" class="nav-icon" />
                        <span>Cadastro</span>
                        <span class="submenu-arrow">▾</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.empresa') }}', this)">
                                <x-icon name="heroicon-o-building-office-2" class="nav-icon nav-icon--sm" />
                                <span>Empresa</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.usuarios') }}', this)">
                                <x-icon name="heroicon-o-users" class="nav-icon nav-icon--sm" />
                                <span>Usuários</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.grupos') }}', this)">
                                <x-icon name="heroicon-o-user-group" class="nav-icon nav-icon--sm" />
                                <span>Grupos de Usuários</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.clientes') }}', this)">
                                <x-icon name="heroicon-o-user" class="nav-icon nav-icon--sm" />
                                <span>Clientes</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.fornecedores') }}', this)">
                                <x-icon name="heroicon-o-truck" class="nav-icon nav-icon--sm" />
                                <span>Fornecedores</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('pagina.lista.vendedores') }}', this)">
                                <x-icon name="heroicon-o-identification" class="nav-icon nav-icon--sm" />
                                <span>Vendedores</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="submenu-toggle" onclick="toggleSubmenu(this)">
                        <x-icon name="heroicon-o-cog-6-tooth" class="nav-icon" />
                        <span>Configuração</span>
                        <span class="submenu-arrow">▾</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('#', this)">
                                <x-icon name="heroicon-o-adjustments-horizontal" class="nav-icon nav-icon--sm" />
                                <span>Parâmetros</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="loadContent('#', this)">
                                <x-icon name="heroicon-o-shield-check" class="nav-icon nav-icon--sm" />
                                <span>Permissões</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
            <p>Sistema ERP · v1.0</p>
        </div>
        
        <form method="POST" action="{{ route('pagina.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <x-icon name="heroicon-o-arrow-right-on-rectangle" class="nav-icon" />
                <span>Sair</span>
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
