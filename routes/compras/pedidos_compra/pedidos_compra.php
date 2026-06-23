<?php

use App\Http\Controllers\Compras\PedidosCompraController;

Route::get('lista-pedidos-compra', [PedidosCompraController::class, 'index'])
    ->name('pagina.lista.pedidos_compra');

Route::get('novo-pedido-compra', [PedidosCompraController::class, 'create'])
    ->name('pagina.novo.pedido_compra');

Route::get('editar-pedido-compra/{id}', [PedidosCompraController::class, 'edit'])
    ->name('pagina.editar.pedido_compra');

Route::post('salvar-pedido-compra', [PedidosCompraController::class, 'store'])
    ->name('pagina.salvar.pedido_compra');

Route::put('atualizar-pedido-compra/{id}', [PedidosCompraController::class, 'update'])
    ->name('pagina.atualizar.pedido_compra');

Route::put('baixar-pedido-compra/{id}', [PedidosCompraController::class, 'baixar'])
    ->name('pagina.baixar.pedido_compra');

Route::delete('deletar-pedido-compra/{id}', [PedidosCompraController::class, 'destroy'])
    ->name('pagina.deletar.pedido_compra');
