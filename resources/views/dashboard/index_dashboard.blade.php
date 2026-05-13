<div class="dash-shell">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --dash-bg: #f1f5f9;
            --dash-surface: #ffffff;
            --dash-border: #e2e8f0;
            --dash-text: #0f172a;
            --dash-text-muted: #64748b;
            --dash-accent: #0c4a6e;
            --dash-accent-soft: #0369a1;
            --dash-radius: 10px;
            --dash-shadow: 0 1px 2px rgba(15, 23, 42, 0.06), 0 4px 12px rgba(15, 23, 42, 0.04);
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            height: 100%;
            background: var(--dash-bg);
        }

        .dash-shell {
            min-height: 100vh;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 14px 24px 28px;
            background: var(--dash-bg);
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--dash-text);
            box-sizing: border-box;
        }

        .dash-shell *,
        .dash-shell *::before,
        .dash-shell *::after {
            box-sizing: border-box;
        }

        .dash-header {
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--dash-border);
        }

        .dash-header__eyebrow {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--dash-text-muted);
            margin: 0 0 3px 0;
        }

        .dash-header__title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 1.125rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--dash-text);
            line-height: 1.2;
        }

        .dash-header__title .dash-icon {
            width: 1.25rem;
            height: 1.25rem;
            color: var(--dash-accent);
            flex-shrink: 0;
        }

        .dash-header__subtitle {
            margin: 4px 0 0 0;
            font-size: 0.8125rem;
            color: var(--dash-text-muted);
            max-width: 52ch;
            line-height: 1.35;
        }

        .dash-kpis {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 22px;
        }

        @media (max-width: 1100px) {
            .dash-kpis { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 560px) {
            .dash-shell { padding: 12px 16px 24px; }
            .dash-kpis { grid-template-columns: 1fr; }
        }

        .dash-kpi {
            position: relative;
            background: var(--dash-surface);
            border: 1px solid var(--dash-border);
            border-radius: var(--dash-radius);
            padding: 20px 20px 20px 22px;
            box-shadow: var(--dash-shadow);
            min-width: 0;
            overflow: hidden;
        }

        .dash-kpi::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            border-radius: var(--dash-radius) 0 0 var(--dash-radius);
            background: var(--dash-kpi-accent, var(--dash-accent));
        }

        .dash-kpi--clients { --dash-kpi-accent: #0c4a6e; }
        .dash-kpi--products { --dash-kpi-accent: #155e75; }
        .dash-kpi--sales { --dash-kpi-accent: #0f766e; }
        .dash-kpi--orders { --dash-kpi-accent: #4338ca; }

        .dash-kpi__top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .dash-kpi__label {
            margin: 0;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--dash-text-muted);
            letter-spacing: 0.02em;
        }

        .dash-kpi__icon {
            width: 2.25rem;
            height: 2.25rem;
            padding: 8px;
            border-radius: 8px;
            background: #f8fafc;
            color: var(--dash-kpi-accent, var(--dash-accent));
            flex-shrink: 0;
        }

        .dash-kpi__value {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--dash-text);
            line-height: 1.2;
            font-variant-numeric: tabular-nums;
        }

        .dash-charts {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 32px;
        }

        @media (max-width: 1100px) {
            .dash-charts { grid-template-columns: 1fr; }
        }

        .dash-chart {
            background: var(--dash-surface);
            border: 1px solid var(--dash-border);
            border-radius: var(--dash-radius);
            box-shadow: var(--dash-shadow);
            min-width: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 320px;
        }

        .dash-chart__head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 18px;
            border-bottom: 1px solid var(--dash-border);
            background: linear-gradient(180deg, #fafbfc 0%, #ffffff 100%);
        }

        .dash-chart__head .dash-icon {
            width: 1.125rem;
            height: 1.125rem;
            color: var(--dash-accent-soft);
            flex-shrink: 0;
        }

        .dash-chart__head h4 {
            margin: 0;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dash-text);
            letter-spacing: -0.01em;
        }

        .dash-chart__body {
            flex: 1;
            padding: 12px 14px 16px;
            position: relative;
            min-height: 0;
        }

        .dash-chart__body canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .dash-section {
            background: var(--dash-surface);
            border: 1px solid var(--dash-border);
            border-radius: var(--dash-radius);
            box-shadow: var(--dash-shadow);
            overflow: hidden;
        }

        .dash-section__head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--dash-border);
            background: linear-gradient(180deg, #fafbfc 0%, #ffffff 100%);
        }

        .dash-section__head .dash-icon {
            width: 1.125rem;
            height: 1.125rem;
            color: var(--dash-accent-soft);
        }

        .dash-section__head h3 {
            margin: 0;
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--dash-text);
        }

        .dash-table-wrap { overflow-x: auto; }

        .dash-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .dash-table thead th {
            text-align: left;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--dash-text-muted);
            background: #f8fafc;
            border-bottom: 1px solid var(--dash-border);
        }

        .dash-table tbody td {
            padding: 14px 20px;
            border-bottom: 1px solid var(--dash-border);
            color: var(--dash-text);
        }

        .dash-table tbody tr:last-child td {
            border-bottom: none;
        }

        .dash-table tbody tr:hover td {
            background: #fafbfc;
        }

        .dash-table tbody tr.dash-table__empty td {
            text-align: center;
            color: var(--dash-text-muted);
            font-size: 0.875rem;
            padding: 28px 20px;
        }
    </style>

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
            <p class="dash-kpi__value">1</p>
        </article>
        <article class="dash-kpi dash-kpi--products">
            <div class="dash-kpi__top">
                <h3 class="dash-kpi__label">Produtos cadastrados</h3>
                <x-icon name="heroicon-o-cube" class="dash-kpi__icon" />
            </div>
            <p class="dash-kpi__value">0</p>
        </article>
        <article class="dash-kpi dash-kpi--sales">
            <div class="dash-kpi__top">
                <h3 class="dash-kpi__label">Vendas (período)</h3>
                <x-icon name="heroicon-o-currency-dollar" class="dash-kpi__icon" />
            </div>
            <p class="dash-kpi__value">R$ 0,00</p>
        </article>
        <article class="dash-kpi dash-kpi--orders">
            <div class="dash-kpi__top">
                <h3 class="dash-kpi__label">Pedidos</h3>
                <x-icon name="heroicon-o-clipboard-document-list" class="dash-kpi__icon" />
            </div>
            <p class="dash-kpi__value">0</p>
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
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                    datasets: [{
                        label: 'Novos clientes',
                        data: [12, 19, 8, 15, 22, 18],
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
                    labels: ['Pessoa física', 'Pessoa jurídica', 'Fornecedores'],
                    datasets: [{
                        data: [45, 30, 25],
                        backgroundColor: corporate.surfaces.slice(0, 3),
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
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                    datasets: [{
                        label: 'Vendas (R$)',
                        data: [2500, 3200, 2800, 4100, 5200, 4800],
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
                    <tr class="dash-table__empty">
                        <td colspan="4">Nenhum cliente recente para exibir.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
