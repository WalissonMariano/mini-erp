<?php

use App\Http\Controllers\Estoque\ItensController;

Route::get('lista-itens', 
    [ItensController::class, 'index']   
)->name('pagina.lista.itens');

Route::get('cadastro-itens',
    [ItensController::class, 'create']
)->name('pagina.cadastro.itens');

Route::get('editar-itens/{id}', 
    [ItensController::class, 'edit']
)->name('pagina.editar.itens');

Route::post('salvar-itens', 
    [ItensController::class, 'store']
)->name('pagina.salvar.itens');

Route::put('atualizar-itens/{id}', 
    [ItensController::class, 'update']
)->name('pagina.atualizar.itens');

Route::delete('deletar-itens/{id}', 
    [ItensController::class, 'destroy']
)->name('pagina.deletar.itens');