<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Rota inicial
Route::get('/', function () {
    return redirect()->route('pagina.login');
})->name('index');

//Login
Route::get('login', 
    [AuthController::class, 'index']
)->name('pagina.login');

Route::post('login', 
    [AuthController::class, 'loginAttempt']
)->name('pagina.login.post');

Route::post('logout', 
    [AuthController::class, 'logout']
)->name('pagina.logout');

//Middleware para proteger as rotas
Route::middleware(['auth'])->group(function () {

    // Menu principal (com iframe)
    Route::get('menu', function () {
        return view('layouts.menu');
    })->name('pagina.menu');


    // Dashboard
    Route::get('dashboard-conteudo', function () {
        return view('dashboard.index-dashboard');
    })->name('pagina.dashboard.conteudo');


    //Rotas de empresa
    require __DIR__ . '/cadastro/empresa/empresa.php';


    //Rotas de grupos
    require __DIR__ . '/cadastro/grupos/grupos.php';


    //Rotas de usuários
    require __DIR__ . '/cadastro/usuarios/usuarios.php';

    // Rotas de clientes
    require __DIR__ . '/cadastro/clientes/clientes.php';

    // Rotas de vendedores
    require __DIR__ . '/cadastro/vendedores/vendedores.php';

    // Rotas de embalagens
    require __DIR__ . '/estoque/embalagens/embalagens.php';

    // Rotas de categorias de itens
    require __DIR__ . '/estoque/itens_categorias/itens_categorias.php';

    // Rotas de itens
    require __DIR__ . '/estoque/itens/itens.php';

    // Rotas de itens embalagens
    require __DIR__ . '/estoque/itens_embalagens/itens_embalagens.php';

    // Rotas de fornecedores
    require __DIR__ . '/cadastro/fornecedores/fornecedores.php';

    // Rotas de pedidos de venda (cabeçalho + itens no mesmo formulário)
    require __DIR__ . '/vendas/pedidos_venda/pedidos_venda.php';

    // Rotas de pedidos de compra (cabeçalho + itens no mesmo formulário)
    require __DIR__ . '/compras/pedidos_compra/pedidos_compra.php';

    // Financeiro — contas a pagar e a receber
    require __DIR__ . '/financeiro/contas_pagar/contas_pagar.php';
    require __DIR__ . '/financeiro/contas_receber/contas_receber.php';

    // Configuração — parâmetros
    require __DIR__ . '/configuracao/parametros/parametros.php';

});

// Rota fallback para páginas não encontradas
Route::fallback(function () {
    return  view('errors.404');
})->name('pagina.fallback');
