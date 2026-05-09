<?php

use App\Http\Controllers\Estoque\ItensCategoriasController;

Route::get('lista-itens-categorias', 
    [ItensCategoriasController::class, 'index']
)->name('pagina.lista.itens_categorias');

Route::get('cadastro-itens-categorias',
    [ItensCategoriasController::class, 'create']
)->name('pagina.cadastro.itens_categorias');

Route::get('editar-itens-categorias/{id}', 
    [ItensCategoriasController::class, 'edit']
)->name('pagina.editar.itens_categorias');

Route::post('salvar-itens-categorias', 
    [ItensCategoriasController::class, 'store']
)->name('pagina.salvar.itens_categorias');

Route::put('atualizar-itens-categorias/{id}', 
    [ItensCategoriasController::class, 'update']
)->name('pagina.atualizar.itens_categorias');

Route::delete('deletar-itens-categorias/{id}', 
    [ItensCategoriasController::class, 'destroy']
)->name('pagina.deletar.itens_categorias');