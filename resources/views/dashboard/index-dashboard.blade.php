@vite('resources/css/layouts/dashboard.css')
<div class="dash-shell">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <header class="dash-header">
        <p class="dash-header__eyebrow">Visão geral</p>
        <h1 class="dash-header__title">
            <x-icon name="heroicon-o-chart-pie" class="dash-icon" />
            Dashboard
        </h1>
    </header>

    <section class="dash-kpis" aria-label="Indicadores principais">
        <article class="dash-kpi dash-kpi--clients">
            <div class="dash-kpi__top">
                <h3 class="dash-kpi__label">Total de clientes</h3>
                <x-icon name="heroicon-o-users" class="dash-kpi__icon" />
            </div>
            <p class="dash-kpi__value">{{ $totalClientes }}</p>
        </article>
        <article class="dash-kpi dash-kpi--products">
            <div class="dash-kpi__top">
                <h3 class="dash-kpi__label">Produtos cadastrados</h3>
                <x-icon name="heroicon-o-cube" class="dash-kpi__icon" />
            </div>
            <p class="dash-kpi__value">{{ $totalProdutos }}</p>
        </article>
        <article class="dash-kpi dash-kpi--sales">
            <div class="dash-kpi__top">
                <h3 class="dash-kpi__label">Vendas (período)</h3>
                <x-icon name="heroicon-o-currency-dollar" class="dash-kpi__icon" />
            </div>
            <p class="dash-kpi__value">R$ {{ number_format($vendasPeriodo, 2, ',', '.') }}</p>
        </article>
        <article class="dash-kpi dash-kpi--orders">
            <div class="dash-kpi__top">
                <h3 class="dash-kpi__label">Pedidos</h3>
                <x-icon name="heroicon-o-clipboard-document-list" class="dash-kpi__icon" />
            </div>
            <p class="dash-kpi__value">{{ $totalPedidos }}</p>
        </article>
    </section>

    <section class="dash-charts" aria-label="Gráficos">
        <div class="dash-chart">
            <div class="dash-chart__head">
                <x-icon name="heroicon-o-arrow-trending-up" class="dash-icon" />
                <h4>Clientes por mês</h4>
            </div>
            <div class="dash-chart__body">
                <canvas id="clientesChart"></canvas>
            </div>
        </div>
        <div class="dash-chart">
            <div class="dash-chart__head">
                <x-icon name="heroicon-o-chart-pie" class="dash-icon" />
                <h4>Distribuição por categoria</h4>
            </div>
            <div class="dash-chart__body">
                <canvas id="categoriasChart"></canvas>
            </div>
        </div>
        <div class="dash-chart">
            <div class="dash-chart__head">
                <x-icon name="heroicon-o-presentation-chart-bar" class="dash-icon" />
                <h4>Vendas mensais</h4>
            </div>
            <div class="dash-chart__body">
                <canvas id="vendasChart"></canvas>
            </div>
        </div>
    </section>

    <script>
        (function () {
            const chartClientesPorMes = @json($chartClientesPorMes);
            const chartCategorias = @json($chartCategorias);
            const chartVendasMensais = @json($chartVendasMensais);

            const corporate = {
                primary: '#0c4a6e',
                secondary: '#0369a1',
                muted: '#64748b',
                grid: '#e2e8f0',
                surfaces: ['#0c4a6e', '#155e75', '#0d9488', '#4338ca', '#64748b', '#94a3b8'],
            };

            function forceChartsResize() {
                if (window.clientesChartInstance) window.clientesChartInstance.resize();
                if (window.categoriasChartInstance) window.categoriasChartInstance.resize();
                if (window.vendasChartInstance) window.vendasChartInstance.resize();
            }

            const chartFont = "system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif";

            const clientesCtx = document.getElementById('clientesChart').getContext('2d');
            window.clientesChartInstance = new Chart(clientesCtx, {
                type: 'line',
                data: {
                    labels: chartClientesPorMes.labels,
                    datasets: [{
                        label: 'Novos clientes',
                        data: chartClientesPorMes.data,
                        borderColor: corporate.primary,
                        backgroundColor: 'rgba(12, 74, 110, 0.08)',
                        tension: 0.35,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: corporate.primary,
                        pointBorderWidth: 2,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: { family: chartFont, size: 11 },
                                color: corporate.muted,
                                boxWidth: 10,
                                usePointStyle: true,
                            },
                        },
                    },
                    scales: {
                        x: {
                            grid: { color: corporate.grid, drawBorder: false },
                            ticks: { font: { family: chartFont, size: 11 }, color: corporate.muted },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: corporate.grid, drawBorder: false },
                            ticks: { font: { family: chartFont, size: 11 }, color: corporate.muted },
                        },
                    },
                },
            });

            const categoriasCtx = document.getElementById('categoriasChart').getContext('2d');
            window.categoriasChartInstance = new Chart(categoriasCtx, {
                type: 'doughnut',
                data: {
                    labels: chartCategorias.labels,
                    datasets: [{
                        data: chartCategorias.data,
                        backgroundColor: corporate.surfaces.slice(0, chartCategorias.labels.length),
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hoverOffset: 6,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '58%',
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                font: { family: chartFont, size: 11 },
                                color: corporate.muted,
                                padding: 14,
                                usePointStyle: true,
                                pointStyle: 'circle',
                            },
                        },
                    },
                },
            });

            const vendasCtx = document.getElementById('vendasChart').getContext('2d');
            window.vendasChartInstance = new Chart(vendasCtx, {
                type: 'bar',
                data: {
                    labels: chartVendasMensais.labels,
                    datasets: [{
                        label: 'Vendas (R$)',
                        data: chartVendasMensais.data,
                        backgroundColor: corporate.surfaces,
                        borderRadius: 6,
                        borderSkipped: false,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: { family: chartFont, size: 11 },
                                color: corporate.muted,
                                boxWidth: 10,
                                usePointStyle: true,
                            },
                        },
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: chartFont, size: 11 }, color: corporate.muted },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: corporate.grid, drawBorder: false },
                            ticks: { font: { family: chartFont, size: 11 }, color: corporate.muted },
                        },
                    },
                },
            });

            window.addEventListener('resize', function () {
                setTimeout(forceChartsResize, 60);
            });

            window.addEventListener('message', function (event) {
                if (event.data && event.data.type === 'erp:layout-resize') {
                    setTimeout(forceChartsResize, 60);
                    setTimeout(forceChartsResize, 300);
                }
            });

            if ('ResizeObserver' in window) {
                new ResizeObserver(function () {
                    forceChartsResize();
                }).observe(document.body);
            }

            setTimeout(forceChartsResize, 120);
        })();
    </script>

    <section class="dash-section" aria-labelledby="dash-recent-clients">
        <div class="dash-section__head">
            <x-icon name="heroicon-o-users" class="dash-icon" />
            <h3 id="dash-recent-clients">Últimos clientes cadastrados</h3>
        </div>
        <div class="dash-table-wrap">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ultimosClientes as $cliente)
                        <tr>
                            <td>{{ $cliente->str_nome }}</td>
                            <td>{{ $cliente->str_email ?: '—' }}</td>
                            <td>{{ $cliente->str_telefone ?: '—' }}</td>
                            <td>{{ $cliente->created_at?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr class="dash-table__empty">
                            <td colspan="4">Nenhum cliente recente para exibir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
