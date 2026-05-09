<?php

use App\Http\Controllers\Estoque\EmbalagensController;

Route::get('lista-embalagens', 
    [EmbalagensController::class, 'index']
)->name('pagina.lista.embalagens');

Route::get('cadastro-embalagens',
    [EmbalagensController::class, 'create']
)->name('pagina.cadastro.embalagens');

Route::get('editar-embalagens/{id}', 
    [EmbalagensController::class, 'edit']
)->name('pagina.editar.embalagens');

Route::post('salvar-embalagens', 
    [EmbalagensController::class, 'store']
)->name('pagina.salvar.embalagens');

Route::put('atualizar-embalagens/{id}', 
    [EmbalagensController::class, 'update']
)->name('pagina.atualizar.embalagens');

Route::delete('deletar-embalagens/{id}', 
    [EmbalagensController::class, 'destroy']
)->name('pagina.deletar.embalagens');