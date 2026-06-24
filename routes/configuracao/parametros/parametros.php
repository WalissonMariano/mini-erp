<?php

use App\Http\Controllers\Configuracao\ParamentrosController;

Route::get('parametros', [ParamentrosController::class, 'edit'])
    ->name('pagina.parametros');

Route::post('salvar-parametros', [ParamentrosController::class, 'store'])
    ->name('pagina.salvar.parametros');

Route::put('atualizar-parametros/{id}', [ParamentrosController::class, 'update'])
    ->name('pagina.atualizar.parametros');
