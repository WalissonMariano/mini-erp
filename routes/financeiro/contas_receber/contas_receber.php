<?php

use App\Http\Controllers\Financeiro\ContasReceberController;

Route::get('lista-contas-receber', [ContasReceberController::class, 'index'])
    ->name('pagina.lista.contas_receber');

Route::get('nova-conta-receber', [ContasReceberController::class, 'create'])
    ->name('pagina.novo.conta_receber');

Route::get('editar-conta-receber/{id}', [ContasReceberController::class, 'edit'])
    ->name('pagina.editar.conta_receber');

Route::post('salvar-conta-receber', [ContasReceberController::class, 'store'])
    ->name('pagina.salvar.conta_receber');

Route::put('atualizar-conta-receber/{id}', [ContasReceberController::class, 'update'])
    ->name('pagina.atualizar.conta_receber');

Route::delete('deletar-conta-receber/{id}', [ContasReceberController::class, 'destroy'])
    ->name('pagina.deletar.conta_receber');
