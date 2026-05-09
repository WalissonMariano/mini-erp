<div style="padding: 0 20px 20px 20px; background-color: #ffffff; min-height: 100vh; font-family: Arial, sans-serif;">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            font-family: Arial, sans-serif;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
            width: 100%;
        }

        @media (max-width: 1024px) {
            .dashboard-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .dashboard-cards {
                grid-template-columns: 1fr;
            }
        }

        .dashboard-card {
            background: white;
            color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            min-width: 0;
        }

        .dashboard-card h3 {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .dashboard-card p {
            font-size: 32px;
            font-weight: bold;
        }

        .dashboard-charts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        @media (max-width: 1024px) {
            .dashboard-charts {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .dashboard-charts {
                grid-template-columns: 1fr;
            }
        }

        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            height: 300px;
            min-width: 0;
            overflow: hidden;
        }

        .chart-container h4 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #2c3e50;
            font-size: 14px;
        }

        .chart-container canvas {
            width: 100% !important;
            height: calc(100% - 30px) !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 15px;
        }

        table thead tr {
            background-color: #34495e;
            color: white;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table tbody tr {
            border-bottom: 1px solid #ddd;
        }

        table tbody tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    <h2>📊 Dashboard</h2>

    <div class="dashboard-cards">
        <div class="dashboard-card" style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5aa0 100%);">
            <h3>👥 Total de Clientes</h3>
            <p>1</p>
        </div>
        <div class="dashboard-card" style="background: linear-gradient(135deg, #2c5aa0 0%, #3d7bc9 100%);">
            <h3>📦 Produtos</h3>
            <p>0</p>
        </div>
        <div class="dashboard-card" style="background: linear-gradient(135deg, #3d7bc9 0%, #5b9ff5 100%);">
            <h3>💰 Vendas</h3>
            <p>R$ 0,00</p>
        </div>
        <div class="dashboard-card" style="background: linear-gradient(135deg, #5b9ff5 0%, #8ec5f9 100%);">
            <h3>📋 Pedidos</h3>
            <p>0</p>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="dashboard-charts">
        <div class="chart-container">
            <h4>📈 Clientes por Mês</h4>
            <canvas id="clientesChart"></canvas>
        </div>
        <div class="chart-container">
            <h4>🥧 Distribuição de Categorias</h4>
            <canvas id="categoriasChart"></canvas>
        </div>
        <div class="chart-container">
            <h4>💹 Vendas Mensais</h4>
            <canvas id="vendasChart"></canvas>
        </div>
    </div>

    <script>
        function forceChartsResize() {
            if (window.clientesChartInstance) {
                window.clientesChartInstance.resize();
            }
            if (window.categoriasChartInstance) {
                window.categoriasChartInstance.resize();
            }
            if (window.vendasChartInstance) {
                window.vendasChartInstance.resize();
            }
        }

        // Gráfico de Clientes por Mês
        const clientesCtx = document.getElementById('clientesChart').getContext('2d');
        window.clientesChartInstance = new Chart(clientesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Novos Clientes',
                    data: [12, 19, 8, 15, 22, 18],
                    borderColor: '#2c5aa0',
                    backgroundColor: 'rgba(44, 90, 160, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Distribuição
        const categoriasCtx = document.getElementById('categoriasChart').getContext('2d');
        window.categoriasChartInstance = new Chart(categoriasCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pessoa Física', 'Pessoa Jurídica', 'Fornecedores'],
                datasets: [{
                    data: [45, 30, 25],
                    backgroundColor: [
                        '#2c5aa0',
                        '#3d7bc9',
                        '#5b9ff5'
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });

        // Gráfico de Vendas
        const vendasCtx = document.getElementById('vendasChart').getContext('2d');
        window.vendasChartInstance = new Chart(vendasCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Vendas (R$)',
                    data: [2500, 3200, 2800, 4100, 5200, 4800],
                    backgroundColor: [
                        '#1e3a5f',
                        '#2c5aa0',
                        '#3d7bc9',
                        '#5b9ff5',
                        '#8ec5f9',
                        '#b8dcf5'
                    ],
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        window.addEventListener('resize', function() {
            setTimeout(forceChartsResize, 60);
        });

        window.addEventListener('message', function(event) {
            if (event.data && event.data.type === 'erp:layout-resize') {
                setTimeout(forceChartsResize, 60);
                setTimeout(forceChartsResize, 300);
            }
        });

        if ('ResizeObserver' in window) {
            const observer = new ResizeObserver(function() {
                forceChartsResize();
            });
            observer.observe(document.body);
        }

        setTimeout(forceChartsResize, 120);
    </script>

    <h3>📝 Últimos Clientes Cadastrados</h3>
    <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 15px;">
        <thead>
            <tr style="background-color: #34495e; color: white;">
                <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Nome</th>
                <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Email</th>
                <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Telefone</th>
                <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Data</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
