<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class DemoSeeder extends Seeder
{
    private const ADMIN_EMAIL = 'admin@admin.com';

    private const GRUPOS = ['Comercial', 'Financeiro'];

    private const USUARIOS = [
        ['nome' => 'Ana Paula Mendes', 'email' => 'comercial@fluxo.demo', 'grupo' => 'Comercial'],
        ['nome' => 'Roberto Lima', 'email' => 'financeiro@fluxo.demo', 'grupo' => 'Financeiro'],
    ];

    private const NOMES_CLIENTES = [
        'Marina Costa', 'Paulo Henrique', 'Juliana Alves', 'Ricardo Mendes', 'Fernanda Lima',
        'André Barbosa', 'Beatriz Souza', 'Carlos Eduardo', 'Daniela Ferreira', 'Eduardo Ramos',
        'Gabriela Nunes', 'Henrique Dias', 'Isabela Martins', 'João Pedro', 'Karina Oliveira',
        'Lucas Almeida', 'Mariana Rocha', 'Nicolas Teixeira', 'Patrícia Gomes', 'Rafael Duarte',
    ];

    private const ENDERECOS = [
        ['logradouro' => 'Rua Augusta', 'bairro' => 'Consolação', 'cidade' => 'São Paulo', 'estado' => 'SP', 'ddd' => '11'],
        ['logradouro' => 'Avenida Norte-Sul', 'bairro' => 'Cambuí', 'cidade' => 'Campinas', 'estado' => 'SP', 'ddd' => '19'],
        ['logradouro' => 'Rua Voluntários da Pátria', 'bairro' => 'Botafogo', 'cidade' => 'Rio de Janeiro', 'estado' => 'RJ', 'ddd' => '21'],
        ['logradouro' => 'Avenida Afonso Pena', 'bairro' => 'Centro', 'cidade' => 'Belo Horizonte', 'estado' => 'MG', 'ddd' => '31'],
        ['logradouro' => 'Rua XV de Novembro', 'bairro' => 'Centro', 'cidade' => 'Curitiba', 'estado' => 'PR', 'ddd' => '41'],
        ['logradouro' => 'Avenida Beira-Mar', 'bairro' => 'Centro', 'cidade' => 'Florianópolis', 'estado' => 'SC', 'ddd' => '48'],
    ];

    private const VENDEDORES = [
        ['nome' => 'Camila Rocha', 'cpf' => '111.222.333-44', 'email' => 'camila.rocha@fluxo.demo', 'telefone' => '(11) 97701-2001', 'logradouro' => 'Rua Haddock Lobo', 'numero' => '90', 'bairro' => 'Cerqueira César', 'cidade' => 'São Paulo', 'estado' => 'SP'],
        ['nome' => 'Bruno Martins', 'cpf' => '222.333.444-55', 'email' => 'bruno.martins@fluxo.demo', 'telefone' => '(11) 97702-2002', 'logradouro' => 'Rua Oscar Freire', 'numero' => '410', 'bairro' => 'Jardins', 'cidade' => 'São Paulo', 'estado' => 'SP'],
        ['nome' => 'Larissa Nunes', 'cpf' => '333.444.555-66', 'email' => 'larissa.nunes@fluxo.demo', 'telefone' => '(19) 97703-2003', 'logradouro' => 'Rua Barão de Jaguara', 'numero' => '700', 'bairro' => 'Centro', 'cidade' => 'Campinas', 'estado' => 'SP'],
    ];

    private const FORNECEDORES = [
        ['nome' => 'Distribuidora Aurora', 'cpf' => '789.012.345-67', 'email' => 'contato@aurora.demo', 'telefone' => '(11) 3333-1001', 'logradouro' => 'Rua do Gasômetro', 'numero' => '150', 'bairro' => 'Brás', 'cidade' => 'São Paulo', 'estado' => 'SP'],
        ['nome' => 'Atacado Serra Verde', 'cpf' => '890.123.456-78', 'email' => 'compras@serraverde.demo', 'telefone' => '(19) 3333-1002', 'logradouro' => 'Rodovia Anhanguera', 'numero' => '1500', 'bairro' => 'Jardim do Trevo', 'cidade' => 'Campinas', 'estado' => 'SP'],
        ['nome' => 'Indústria Norte', 'cpf' => '901.234.567-89', 'email' => 'vendas@norte.demo', 'telefone' => '(11) 3333-1003', 'logradouro' => 'Avenida do Estado', 'numero' => '2200', 'bairro' => 'Bom Retiro', 'cidade' => 'São Paulo', 'estado' => 'SP'],
    ];

    private const CATEGORIAS = ['Mercearia', 'Bebidas', 'Limpeza'];

    private const PRODUTOS = [
        ['Arroz Tipo 1 5kg', 24.90, 'Mercearia'],
        ['Feijão Carioca 1kg', 8.50, 'Mercearia'],
        ['Macarrão Espaguete 500g', 4.20, 'Mercearia'],
        ['Café Torrado 500g', 18.90, 'Mercearia'],
        ['Açúcar Refinado 1kg', 5.40, 'Mercearia'],
        ['Sal Refinado 1kg', 2.80, 'Mercearia'],
        ['Óleo de Soja 900ml', 8.90, 'Mercearia'],
        ['Farinha de Trigo 1kg', 6.30, 'Mercearia'],
        ['Leite em Pó 400g', 16.50, 'Mercearia'],
        ['Achocolatado 400g', 12.40, 'Mercearia'],
        ['Biscoito Cream Cracker 400g', 5.90, 'Mercearia'],
        ['Molho de Tomate 340g', 3.20, 'Mercearia'],
        ['Milho Verde Lata 170g', 4.10, 'Mercearia'],
        ['Ervilha Lata 170g', 4.30, 'Mercearia'],
        ['Aveia em Flocos 250g', 7.80, 'Mercearia'],
        ['Granola Tradicional 250g', 11.90, 'Mercearia'],
        ['Extrato de Tomate 350g', 6.70, 'Mercearia'],
        ['Vinagre de Álcool 750ml', 3.60, 'Mercearia'],
        ['Refrigerante Cola 2L', 7.50, 'Bebidas'],
        ['Suco de Laranja 1L', 6.80, 'Bebidas'],
        ['Água Mineral 500ml', 2.10, 'Bebidas'],
        ['Refrigerante Guaraná 2L', 7.20, 'Bebidas'],
        ['Suco de Uva 1L', 7.40, 'Bebidas'],
        ['Água com Gás 500ml', 2.40, 'Bebidas'],
        ['Chá Gelado Limão 1L', 5.90, 'Bebidas'],
        ['Energético 250ml', 8.50, 'Bebidas'],
        ['Suco de Maracujá 1L', 6.90, 'Bebidas'],
        ['Refrigerante Laranja 2L', 7.10, 'Bebidas'],
        ['Água Mineral 1,5L', 3.20, 'Bebidas'],
        ['Néctar de Pêssego 1L', 6.40, 'Bebidas'],
        ['Isotônico 500ml', 5.80, 'Bebidas'],
        ['Cerveja Pilsen 350ml', 4.50, 'Bebidas'],
        ['Suco de Maçã 1L', 6.60, 'Bebidas'],
        ['Água de Coco 1L', 8.90, 'Bebidas'],
        ['Detergente Neutro 500ml', 3.40, 'Limpeza'],
        ['Sabão em Pó 1kg', 12.90, 'Limpeza'],
        ['Água Sanitária 1L', 4.80, 'Limpeza'],
        ['Amaciante 2L', 14.50, 'Limpeza'],
        ['Desinfetante 2L', 9.90, 'Limpeza'],
        ['Esponja Dupla Face', 2.50, 'Limpeza'],
        ['Sabão em Barra 200g', 3.10, 'Limpeza'],
        ['Limpador Multiuso 500ml', 6.20, 'Limpeza'],
        ['Papel Higiênico 12 rolos', 18.90, 'Limpeza'],
        ['Sabonete 90g', 2.80, 'Limpeza'],
        ['Alvejante sem Cloro 1L', 11.40, 'Limpeza'],
        ['Limpa Vidros 500ml', 7.60, 'Limpeza'],
        ['Inseticida Aerossol 300ml', 13.90, 'Limpeza'],
        ['Saco de Lixo 30L', 8.40, 'Limpeza'],
        ['Detergente Coco 500ml', 3.70, 'Limpeza'],
        ['Álcool 70% 1L', 9.50, 'Limpeza'],
    ];

    /** @var array<int, array<string, string>>|null */
    private ?array $clientesCache = null;

    /** @var array<int, array<string, mixed>>|null */
    private ?array $itensCache = null;

    private const EMBALAGENS = [
        ['sigla' => 'UN', 'descricao' => 'Unidade', 'quantidade' => 1],
        ['sigla' => 'CX', 'descricao' => 'Caixa', 'quantidade' => 12],
        ['sigla' => 'FD', 'descricao' => 'Fardo', 'quantidade' => 6],
    ];

    public function run(): void
    {
        DB::transaction(function () {
            $this->purgeDemoData();
            $this->seedDemoData();
        });
    }

    private function purgeDemoData(): void
    {
        $clienteIds = DB::table('clientes')->where(function ($query) {
            $query->whereIn('str_email', $this->emails($this->clientes()))
                ->orWhere('str_email', 'like', '%@exemplo.com');
        })->pluck('id');
        $vendedorIds = DB::table('vendedores')->whereIn('str_email', $this->emails(self::VENDEDORES))->pluck('id');
        $fornecedorIds = DB::table('fornecedores')->whereIn('str_email', $this->emails(self::FORNECEDORES))->pluck('id');
        $categoriaIds = DB::table('itens_categorias')->whereIn('str_descricao', self::CATEGORIAS)->pluck('id');
        $itemIds = DB::table('itens')->where(function ($query) use ($categoriaIds) {
            $query->whereIn('str_codigo', array_column($this->itens(), 'codigo'));
            if ($categoriaIds->isNotEmpty()) {
                $query->orWhereIn('categoria_id', $categoriaIds);
            }
        })->pluck('id');
        $embalagemIds = DB::table('embalagens')->whereIn('str_sigla', array_column(self::EMBALAGENS, 'sigla'))->pluck('id');

        if ($clienteIds->isNotEmpty()) {
            DB::table('contas_receber')->whereIn('cliente_id', $clienteIds)->delete();
            $this->deletePedidos('pedidos_venda', 'pedidos_vendas_itens', 'pedidos_venda_id', 'cliente_id', $clienteIds);
        }

        if ($vendedorIds->isNotEmpty()) {
            $this->deletePedidos('pedidos_venda', 'pedidos_vendas_itens', 'pedidos_venda_id', 'vendedor_id', $vendedorIds);
            DB::table('vendedores')->whereIn('id', $vendedorIds)->delete();
        }

        if ($fornecedorIds->isNotEmpty()) {
            DB::table('contas_pagar')->whereIn('fornecedores_id', $fornecedorIds)->delete();
            $this->deletePedidos('pedidos_compras', 'pedidos_compras_itens', 'pedido_compra_id', 'fornecedores_id', $fornecedorIds);
            DB::table('fornecedores')->whereIn('id', $fornecedorIds)->delete();
        }

        if ($clienteIds->isNotEmpty()) {
            DB::table('clientes')->whereIn('id', $clienteIds)->delete();
        }

        $this->deletePedidosPorItem('pedidos_vendas_itens', 'pedidos_venda', 'pedidos_venda_id', 'itens_id', $itemIds);
        $this->deletePedidosPorItem('pedidos_compras_itens', 'pedidos_compras', 'pedido_compra_id', 'item_id', $itemIds);

        if ($itemIds->isNotEmpty() || $embalagemIds->isNotEmpty()) {
            DB::table('itens_embalagens')
                ->where(function ($query) use ($itemIds, $embalagemIds) {
                    if ($itemIds->isNotEmpty()) {
                        $query->orWhereIn('item_id', $itemIds);
                    }
                    if ($embalagemIds->isNotEmpty()) {
                        $query->orWhereIn('embalagem_id', $embalagemIds);
                    }
                })
                ->delete();
        }

        if ($itemIds->isNotEmpty()) {
            DB::table('itens')->whereIn('id', $itemIds)->delete();
        }

        if ($embalagemIds->isNotEmpty()) {
            DB::table('embalagens')->whereIn('id', $embalagemIds)->delete();
        }

        DB::table('itens_categorias')->whereIn('str_descricao', self::CATEGORIAS)->delete();

        DB::table('usuarios')->whereIn('str_email', array_column(self::USUARIOS, 'email'))->delete();

        $grupoIds = DB::table('grupos')->whereIn('str_nome', self::GRUPOS)->pluck('id');
        if ($grupoIds->isNotEmpty() && ! DB::table('usuarios')->whereIn('grupo_id', $grupoIds)->exists()) {
            DB::table('grupos')->whereIn('id', $grupoIds)->delete();
        }
    }

    private function seedDemoData(): void
    {
        $admin = DB::table('usuarios')->where('str_email', self::ADMIN_EMAIL)->first();

        if (! $admin) {
            throw new RuntimeException('Usuário admin@admin.com não encontrado. Rode as migrations primeiro.');
        }

        $empresaId = $admin->empresa_id;
        $grupoIds = $this->seedGrupos();
        $this->seedUsuarios($empresaId, $grupoIds);

        $clienteIds = $this->seedPessoas('clientes', $this->clientes(), $empresaId, true);
        $vendedorIds = $this->seedPessoas('vendedores', self::VENDEDORES, $empresaId, false);
        $fornecedorIds = $this->seedPessoas('fornecedores', self::FORNECEDORES, $empresaId, false);
        $itemIds = $this->seedCatalogo();

        $this->seedPedidosVenda($empresaId, $clienteIds, $vendedorIds, $itemIds);
        $this->seedPedidosCompra($empresaId, $fornecedorIds, $itemIds);
        $this->seedContasReceber($empresaId, $clienteIds);
        $this->seedContasPagar($empresaId, $fornecedorIds);
    }

    private function seedGrupos(): array
    {
        $ids = [];
        $now = now();

        foreach (self::GRUPOS as $nome) {
            $id = (string) Str::uuid();
            DB::table('grupos')->insert([
                'id' => $id,
                'str_nome' => $nome,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $ids[$nome] = $id;
        }

        return $ids;
    }

    private function seedUsuarios(string $empresaId, array $grupoIds): void
    {
        $now = now();
        $password = Hash::make('123456');

        foreach (self::USUARIOS as $usuario) {
            DB::table('usuarios')->insert([
                'id' => (string) Str::uuid(),
                'str_nome' => $usuario['nome'],
                'str_email' => $usuario['email'],
                'str_password' => $password,
                'empresa_id' => $empresaId,
                'grupo_id' => $grupoIds[$usuario['grupo']],
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * @param  array<int, array<string, string>>  $pessoas
     * @return array<int, string>
     */
    private function seedPessoas(string $tabela, array $pessoas, string $empresaId, bool $espalharMeses): array
    {
        $ids = [];

        foreach ($pessoas as $index => $pessoa) {
            $criado = $espalharMeses
                ? $this->dataNoMes(5 - ($index % 6), 3 + intdiv($index, 6))
                : now()->subDays(max(1, 20 - $index));

            $id = (string) Str::uuid();
            DB::table($tabela)->insert([
                'id' => $id,
                'str_nome' => $pessoa['nome'],
                'str_cpf' => $pessoa['cpf'],
                'str_email' => $pessoa['email'],
                'str_telefone' => $pessoa['telefone'],
                'str_logradouro' => $pessoa['logradouro'],
                'str_numero' => $pessoa['numero'],
                'str_bairro' => $pessoa['bairro'],
                'str_cidade' => $pessoa['cidade'],
                'str_estado' => $pessoa['estado'],
                'empresa_id' => $empresaId,
                'created_at' => $criado,
                'updated_at' => $criado,
            ]);
            $ids[] = $id;
        }

        return $ids;
    }

    /**
     * @return array<string, string>
     */
    private function seedCatalogo(): array
    {
        $now = now();
        $categoriaIds = [];

        foreach (self::CATEGORIAS as $descricao) {
            $id = (string) Str::uuid();
            DB::table('itens_categorias')->insert([
                'id' => $id,
                'str_descricao' => $descricao,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $categoriaIds[$descricao] = $id;
        }

        $embalagemIds = [];
        foreach (self::EMBALAGENS as $embalagem) {
            $id = (string) Str::uuid();
            DB::table('embalagens')->insert([
                'id' => $id,
                'str_sigla' => $embalagem['sigla'],
                'str_descricao' => $embalagem['descricao'],
                'dbl_quantidade_embalagem' => $embalagem['quantidade'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $embalagemIds[$embalagem['sigla']] = $id;
        }

        $itemIds = [];
        foreach ($this->itens() as $indice => $item) {
            $id = (string) Str::uuid();
            DB::table('itens')->insert([
                'id' => $id,
                'str_codigo' => $item['codigo'],
                'str_descricao' => $item['descricao'],
                'dbl_preco' => $item['preco'],
                'categoria_id' => $categoriaIds[$item['categoria']],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $itemIds[$item['codigo']] = $id;

            foreach (['UN', 'CX'] as $sigla) {
                DB::table('itens_embalagens')->insert([
                    'id' => (string) Str::uuid(),
                    'item_id' => $id,
                    'embalagem_id' => $embalagemIds[$sigla],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            if ($indice % 5 === 0) {
                DB::table('itens_embalagens')->insert([
                    'id' => (string) Str::uuid(),
                    'item_id' => $id,
                    'embalagem_id' => $embalagemIds['FD'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        return $itemIds;
    }

    /**
     * @param  array<int, string>  $clienteIds
     * @param  array<int, string>  $vendedorIds
     * @param  array<string, string>  $itemIds
     */
    private function seedPedidosVenda(string $empresaId, array $clienteIds, array $vendedorIds, array $itemIds): void
    {
        $codigos = array_keys($itemIds);
        $baixados = 24;

        for ($indice = 0; $indice < 30; $indice++) {
            $aberto = $indice >= $baixados;
            $data = $aberto
                ? now()->subDays(($indice % 5) + 1)
                : $this->dataNoMes(5 - intdiv($indice, 4), 4 + ($indice % 20));

            $this->inserirPedido(
                'pedidos_venda',
                'pedidos_vendas_itens',
                'pedidos_venda_id',
                'itens_id',
                [
                    'numero_pedido' => $indice + 1,
                    'empresa_id' => $empresaId,
                    'cliente_id' => $clienteIds[$indice % count($clienteIds)],
                    'vendedor_id' => $vendedorIds[$indice % count($vendedorIds)],
                    'data_pedido' => $data->toDateString(),
                    'status' => $aberto ? 'A' : 'B',
                    'str_observacao' => $aberto ? 'Pedido em aberto na demonstração.' : 'Pedido faturado na demonstração.',
                ],
                $this->linhasDoPedido($codigos, $indice),
                $itemIds,
                1,
                $data
            );
        }
    }

    /**
     * @param  array<int, string>  $fornecedorIds
     * @param  array<string, string>  $itemIds
     */
    private function seedPedidosCompra(string $empresaId, array $fornecedorIds, array $itemIds): void
    {
        $codigos = array_keys($itemIds);

        for ($indice = 0; $indice < 8; $indice++) {
            $aberto = $indice >= 6;
            $data = $aberto
                ? now()->subDays($indice - 4)
                : $this->dataNoMes(5 - $indice, 5);

            $this->inserirPedido(
                'pedidos_compras',
                'pedidos_compras_itens',
                'pedido_compra_id',
                'item_id',
                [
                    'numero_pedido' => $indice + 1,
                    'empresa_id' => $empresaId,
                    'fornecedores_id' => $fornecedorIds[$indice % count($fornecedorIds)],
                    'data_pedido' => $data->toDateString(),
                    'status' => $aberto ? 'A' : 'B',
                    'str_observacao' => $aberto ? 'Compra em aberto na demonstração.' : 'Compra recebida na demonstração.',
                ],
                $this->linhasDoPedido($codigos, $indice + 3),
                $itemIds,
                0.72,
                $data
            );
        }
    }

    /**
     * @param  array<int, string>  $clienteIds
     */
    private function seedContasReceber(string $empresaId, array $clienteIds): void
    {
        $hoje = now()->startOfDay();
        $contas = [
            ['cliente' => 0, 'descricao' => 'Venda de mercearia — parcela 1', 'valor' => 450.00, 'vencimento' => $hoje->copy()->addDays(7), 'status' => 'aberto'],
            ['cliente' => 1, 'descricao' => 'Venda de bebidas — parcela única', 'valor' => 280.50, 'vencimento' => $hoje->copy()->addDays(15), 'status' => 'aberto'],
            ['cliente' => 2, 'descricao' => 'Pedido faturado de café e massas', 'valor' => 960.00, 'vencimento' => $hoje->copy()->subDays(20), 'recebimento' => $hoje->copy()->subDays(12), 'status' => 'pago'],
            ['cliente' => 3, 'descricao' => 'Reposição de limpeza', 'valor' => 310.40, 'vencimento' => $hoje->copy()->subDays(8), 'recebimento' => $hoje->copy()->subDays(5), 'status' => 'pago'],
            ['cliente' => 4, 'descricao' => 'Pedido cancelado pelo cliente', 'valor' => 150.00, 'vencimento' => $hoje->copy()->subDays(2), 'status' => 'cancelado'],
        ];

        foreach ($contas as $conta) {
            $this->inserirConta('contas_receber', [
                'empresa_id' => $empresaId,
                'cliente_id' => $clienteIds[$conta['cliente']],
                'str_descricao' => $conta['descricao'],
                'dbl_valor' => $conta['valor'],
                'data_vencimento' => $conta['vencimento']->toDateString(),
                'data_recebimento' => isset($conta['recebimento']) ? $conta['recebimento']->toDateString() : null,
                'status' => $conta['status'],
            ]);
        }
    }

    /**
     * @param  array<int, string>  $fornecedorIds
     */
    private function seedContasPagar(string $empresaId, array $fornecedorIds): void
    {
        $hoje = now()->startOfDay();
        $contas = [
            ['fornecedor' => 0, 'descricao' => 'Compra de mercearia — nota 1042', 'valor' => 1280.00, 'vencimento' => $hoje->copy()->addDays(5), 'status' => 'aberto'],
            ['fornecedor' => 1, 'descricao' => 'Compra de bebidas — nota 778', 'valor' => 640.90, 'vencimento' => $hoje->copy()->addDays(12), 'status' => 'aberto'],
            ['fornecedor' => 2, 'descricao' => 'Reposição de estoque paga', 'valor' => 890.00, 'vencimento' => $hoje->copy()->subDays(15), 'pagamento' => $hoje->copy()->subDays(10), 'status' => 'pago'],
            ['fornecedor' => 0, 'descricao' => 'Frete de entrega pago', 'valor' => 180.00, 'vencimento' => $hoje->copy()->subDays(6), 'pagamento' => $hoje->copy()->subDays(4), 'status' => 'pago'],
            ['fornecedor' => 1, 'descricao' => 'Pedido de compra cancelado', 'valor' => 220.00, 'vencimento' => $hoje->copy()->subDays(1), 'status' => 'cancelado'],
        ];

        foreach ($contas as $conta) {
            $this->inserirConta('contas_pagar', [
                'empresa_id' => $empresaId,
                'fornecedores_id' => $fornecedorIds[$conta['fornecedor']],
                'str_descricao' => $conta['descricao'],
                'dbl_valor' => $conta['valor'],
                'data_vencimento' => $conta['vencimento']->toDateString(),
                'data_pagamento' => isset($conta['pagamento']) ? $conta['pagamento']->toDateString() : null,
                'status' => $conta['status'],
            ]);
        }
    }

    /**
     * @param  array<string, mixed>  $cabecalho
     * @param  array<int, array{0: string, 1: int}>  $linhas
     * @param  array<string, string>  $itemIds
     */
    private function inserirPedido(
        string $tabela,
        string $tabelaItens,
        string $colunaPedido,
        string $colunaItem,
        array $cabecalho,
        array $linhas,
        array $itemIds,
        float $fatorPreco,
        Carbon $data
    ): void {
        $precos = $this->precos();
        $pedidoId = (string) Str::uuid();
        $total = 0;

        foreach ($linhas as [$codigo, $quantidade]) {
            $unitario = round((float) $precos[$codigo] * $fatorPreco, 2);
            $total += round($quantidade * $unitario, 2);
        }

        DB::table($tabela)->insert(array_merge($cabecalho, [
            'id' => $pedidoId,
            'dbl_valor_total' => round($total, 2),
            'created_at' => $data,
            'updated_at' => $data,
        ]));

        foreach ($linhas as [$codigo, $quantidade]) {
            $unitario = round((float) $precos[$codigo] * $fatorPreco, 2);
            DB::table($tabelaItens)->insert([
                'id' => (string) Str::uuid(),
                $colunaPedido => $pedidoId,
                $colunaItem => $itemIds[$codigo],
                'dbl_quantidade' => $quantidade,
                'dbl_valor_unitario' => $unitario,
                'dbl_valor_total' => round($quantidade * $unitario, 2),
                'created_at' => $data,
                'updated_at' => $data,
            ]);
        }
    }

    /**
     * @param  array<string, mixed>  $dados
     */
    private function inserirConta(string $tabela, array $dados): void
    {
        $agora = now();
        DB::table($tabela)->insert(array_merge($dados, [
            'id' => (string) Str::uuid(),
            'str_observacao' => null,
            'created_at' => $agora,
            'updated_at' => $agora,
        ]));
    }

    /**
     * @param  Collection<int, string>  $ids
     */
    private function deletePedidos(string $tabela, string $tabelaItens, string $colunaPedido, string $colunaFiltro, Collection $ids): void
    {
        $pedidoIds = DB::table($tabela)->whereIn($colunaFiltro, $ids)->pluck('id');

        if ($pedidoIds->isEmpty()) {
            return;
        }

        DB::table($tabelaItens)->whereIn($colunaPedido, $pedidoIds)->delete();
        DB::table($tabela)->whereIn('id', $pedidoIds)->delete();
    }

    private function dataNoMes(int $mesesAtras, int $dia): Carbon
    {
        $data = now()->subMonths($mesesAtras)->startOfMonth()->addDays($dia - 1)->startOfDay();

        if ($data->greaterThan(now())) {
            return now()->startOfDay();
        }

        return $data;
    }

    /**
     * @param  array<int, array<string, string>>  $registros
     * @return array<int, string>
     */
    private function emails(array $registros): array
    {
        return array_column($registros, 'email');
    }

    /**
     * @param  array<int, string>  $codigos
     * @return array<int, array{0: string, 1: int}>
     */
    private function linhasDoPedido(array $codigos, int $indice): array
    {
        $quantidadeLinhas = 1 + ($indice % 3);
        $linhas = [];

        for ($linha = 0; $linha < $quantidadeLinhas; $linha++) {
            $linhas[] = [
                $codigos[($indice * 3 + $linha) % count($codigos)],
                4 + (($indice + $linha) % 20),
            ];
        }

        return $linhas;
    }

    /**
     * @param  Collection<int, string>  $itemIds
     */
    private function deletePedidosPorItem(string $tabelaItens, string $tabela, string $colunaPedido, string $colunaItem, Collection $itemIds): void
    {
        if ($itemIds->isEmpty()) {
            return;
        }

        $pedidoIds = DB::table($tabelaItens)->whereIn($colunaItem, $itemIds)->pluck($colunaPedido)->unique();

        if ($pedidoIds->isEmpty()) {
            return;
        }

        DB::table($tabelaItens)->whereIn($colunaPedido, $pedidoIds)->delete();
        DB::table($tabela)->whereIn('id', $pedidoIds)->delete();
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function clientes(): array
    {
        if ($this->clientesCache !== null) {
            return $this->clientesCache;
        }

        $this->clientesCache = [];

        foreach (self::NOMES_CLIENTES as $indice => $nome) {
            $endereco = self::ENDERECOS[$indice % count(self::ENDERECOS)];
            $numero = $indice + 1;

            $this->clientesCache[] = [
                'nome' => $nome,
                'cpf' => $this->cpf(200 + $numero),
                'email' => Str::slug($nome, '.').'@exemplo.com',
                'telefone' => sprintf('(%s) 988%02d-%04d', $endereco['ddd'], $numero, 1000 + $numero),
                'logradouro' => $endereco['logradouro'],
                'numero' => (string) (100 + $numero),
                'bairro' => $endereco['bairro'],
                'cidade' => $endereco['cidade'],
                'estado' => $endereco['estado'],
            ];
        }

        return $this->clientesCache;
    }

    /**
     * @return array<int, array{codigo: string, descricao: string, preco: float, categoria: string}>
     */
    private function itens(): array
    {
        if ($this->itensCache !== null) {
            return $this->itensCache;
        }

        $this->itensCache = [];

        foreach (self::PRODUTOS as $indice => $produto) {
            $this->itensCache[] = [
                'codigo' => sprintf('PRD-%03d', $indice + 1),
                'descricao' => $produto[0],
                'preco' => $produto[1],
                'categoria' => $produto[2],
            ];
        }

        return $this->itensCache;
    }

    /**
     * @return array<string, float>
     */
    private function precos(): array
    {
        $precos = [];

        foreach ($this->itens() as $item) {
            $precos[$item['codigo']] = (float) $item['preco'];
        }

        return $precos;
    }

    private function cpf(int $sequencia): string
    {
        $digitos = str_pad((string) $sequencia, 11, '0', STR_PAD_LEFT);

        return substr($digitos, 0, 3).'.'.substr($digitos, 3, 3).'.'.substr($digitos, 6, 3).'-'.substr($digitos, 9, 2);
    }
}
