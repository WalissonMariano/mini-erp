<?php

use App\Http\Controllers\Vendas\PedidosVendaController;

Route::get('lista-pedidos-venda', [PedidosVendaController::class, 'index'])
    ->name('pagina.lista.pedidos_venda');

Route::get('novo-pedido-venda', [PedidosVendaController::class, 'create'])
    ->name('pagina.novo.pedido_venda');

Route::get('editar-pedido-venda/{id}', [PedidosVendaController::class, 'edit'])
    ->name('pagina.editar.pedido_venda');

Route::post('salvar-pedido-venda', [PedidosVendaController::class, 'store'])
    ->name('pagina.salvar.pedido_venda');

Route::put('atualizar-pedido-venda/{id}', [PedidosVendaController::class, 'update'])
    ->name('pagina.atualizar.pedido_venda');

Route::put('baixar-pedido-venda/{id}', [PedidosVendaController::class, 'baixar'])
    ->name('pagina.baixar.pedido_venda');

Route::delete('deletar-pedido-venda/{id}', [PedidosVendaController::class, 'destroy'])
    ->name('pagina.deletar.pedido_venda');
