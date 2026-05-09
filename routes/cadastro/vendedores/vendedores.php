<?php

use App\Http\Controllers\Cadastro\VendedoresController;

Route::get('lista-vendedores', 
    [VendedoresController::class, 'index']
)->name('pagina.lista.vendedores');

Route::get('cadastro-vendedores',
    [VendedoresController::class, 'create']
)->name('pagina.cadastro.vendedores');

Route::get('editar-vendedores/{id}', 
    [VendedoresController::class, 'edit']
)->name('pagina.editar.vendedores');

Route::post('salvar-vendedores', 
    [VendedoresController::class, 'store']
)->name('pagina.salvar.vendedores');

Route::put('atualizar-vendedores/{id}', 
    [VendedoresController::class, 'update']
)->name('pagina.atualizar.vendedores');

Route::delete('deletar-vendedores/{id}', 
    [VendedoresController::class, 'destroy']
)->name('pagina.deletar.vendedores');