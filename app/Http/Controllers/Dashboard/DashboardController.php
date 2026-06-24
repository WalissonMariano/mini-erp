<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cadastro\Clientes;
use App\Models\Estoque\Itens;
use App\Models\Venda\PedidosVenda;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    private const MESES_ABREV = [
        1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr', 5 => 'Mai', 6 => 'Jun',
        7 => 'Jul', 8 => 'Ago', 9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez',
    ];

    public function index()
    {
        return view('dashboard.index-dashboard', [
            'totalClientes' => $this->totalClientes(),
            'totalProdutos' => $this->totalProdutos(),
            'vendasPeriodo' => $this->vendasPeriodo(),
            'totalPedidos' => $this->totalPedidos(),
            'ultimosClientes' => $this->ultimosClientes(),
            'chartClientesPorMes' => $this->chartClientesPorMes(),
            'chartCategorias' => $this->chartCategorias(),
            'chartVendasMensais' => $this->chartVendasMensais(),
        ]);
    }

    private function totalClientes(): int
    {
        return Clientes::count();
    }

    private function totalProdutos(): int
    {
        return Itens::count();
    }

    private function vendasPeriodo(): float
    {
        return (float) PedidosVenda::query()
            ->where('status', PedidosVenda::STATUS_BAIXADO)
            ->whereMonth('data_pedido', now()->month)
            ->whereYear('data_pedido', now()->year)
            ->sum('dbl_valor_total');
    }

    private function totalPedidos(): int
    {
        return PedidosVenda::count();
    }

    private function ultimosClientes(): Collection
    {
        return Clientes::query()
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(['str_nome', 'str_email', 'str_telefone', 'created_at']);
    }

    private function chartClientesPorMes(): array
    {
        $periodo = $this->periodoUltimosSeisMeses();
        $inicio = $periodo->first()['inicio'];

        $totais = Clientes::query()
            ->where('created_at', '>=', $inicio)
            ->get(['created_at'])
            ->groupBy(fn (Clientes $cliente) => $cliente->created_at->format('Y-m'))
            ->map(fn (Collection $grupo) => $grupo->count());

        return [
            'labels' => $periodo->pluck('label')->all(),
            'data' => $periodo->map(fn (array $mes) => (int) ($totais[$mes['chave']] ?? 0))->all(),
        ];
    }

    private function chartCategorias(): array
    {
        $itens = Itens::query()
            ->with('categoria:id,str_descricao')
            ->get(['id', 'categoria_id']);

        $agrupado = $itens->groupBy(function (Itens $item) {
            return $item->categoria?->str_descricao ?? 'Sem categoria';
        })->map(fn (Collection $grupo) => $grupo->count())
            ->sortDesc();

        if ($agrupado->isEmpty()) {
            return [
                'labels' => ['Sem dados'],
                'data' => [0],
            ];
        }

        return [
            'labels' => $agrupado->keys()->values()->all(),
            'data' => $agrupado->values()->all(),
        ];
    }

    private function chartVendasMensais(): array
    {
        $periodo = $this->periodoUltimosSeisMeses();
        $inicio = $periodo->first()['inicio'];

        $totais = PedidosVenda::query()
            ->where('status', PedidosVenda::STATUS_BAIXADO)
            ->where('data_pedido', '>=', $inicio->toDateString())
            ->get(['data_pedido', 'dbl_valor_total'])
            ->groupBy(fn (PedidosVenda $pedido) => $pedido->data_pedido->format('Y-m'))
            ->map(fn (Collection $grupo) => (float) $grupo->sum('dbl_valor_total'));

        return [
            'labels' => $periodo->pluck('label')->all(),
            'data' => $periodo->map(fn (array $mes) => round((float) ($totais[$mes['chave']] ?? 0), 2))->all(),
        ];
    }

    private function periodoUltimosSeisMeses(): Collection
    {
        return collect(range(5, 0))->map(function (int $mesesAtras) {
            $data = now()->subMonths($mesesAtras)->startOfMonth();

            return [
                'chave' => $data->format('Y-m'),
                'label' => self::MESES_ABREV[(int) $data->format('n')],
                'inicio' => $data->copy(),
            ];
        });
    }
}
