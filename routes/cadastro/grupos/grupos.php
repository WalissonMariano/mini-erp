<?php

use App\Http\Controllers\Cadastro\GruposController;

Route::get('lista-grupos', 
    [GruposController::class, 'index']
)->name('pagina.lista.grupos');

Route::get('cadastro-grupos',
    [GruposController::class, 'create']
)->name('pagina.cadastro.grupos');

Route::get('editar-grupos/{id}', 
    [GruposController::class, 'edit']
)->name('pagina.editar.grupos');

Route::post('salvar-grupos', 
    [GruposController::class, 'store']
)->name('pagina.salvar.grupos');

Route::put('atualizar-grupos/{id}', 
    [GruposController::class, 'update']
)->name('pagina.atualizar.grupos');

Route::delete('deletar-grupos/{id}', 
    [GruposController::class, 'destroy']
)->name('pagina.deletar.grupos');