<?php 

use App\Http\Controllers\Cadastro\FornecedoresController;

Route::get('lista-fornecedores', 
    [FornecedoresController::class, 'index']
)->name('pagina.lista.fornecedores');

Route::get('novo-fornecedor',  
    [FornecedoresController::class, 'create']
)->name('pagina.novo.fornecedor');

Route::get('editar-fornecedor/{id}', 
    [FornecedoresController::class, 'edit']
)->name('pagina.editar.fornecedor');

Route::post('salvar-fornecedor', 
    [FornecedoresController::class, 'store']
)->name('pagina.salvar.fornecedor');

Route::put('atualizar-fornecedor/{id}', 
    [FornecedoresController::class, 'update']
)->name('pagina.atualizar.fornecedor');

Route::delete('deletar-fornecedor/{id}', 
    [FornecedoresController::class, 'destroy']
)->name('pagina.deletar.fornecedor');