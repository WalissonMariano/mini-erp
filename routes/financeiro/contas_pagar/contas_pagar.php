<?php

use App\Http\Controllers\Financeiro\ContasPagarController;

Route::get('lista-contas-pagar', [ContasPagarController::class, 'index'])
    ->name('pagina.lista.contas_pagar');

Route::get('nova-conta-pagar', [ContasPagarController::class, 'create'])
    ->name('pagina.novo.conta_pagar');

Route::get('editar-conta-pagar/{id}', [ContasPagarController::class, 'edit'])
    ->name('pagina.editar.conta_pagar');

Route::post('salvar-conta-pagar', [ContasPagarController::class, 'store'])
    ->name('pagina.salvar.conta_pagar');

Route::put('atualizar-conta-pagar/{id}', [ContasPagarController::class, 'update'])
    ->name('pagina.atualizar.conta_pagar');

Route::delete('deletar-conta-pagar/{id}', [ContasPagarController::class, 'destroy'])
    ->name('pagina.deletar.conta_pagar');
