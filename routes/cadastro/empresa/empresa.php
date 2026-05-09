<?php 

use App\Http\Controllers\Cadastro\EmpresaController;

Route::get('lista-empresa', 
    [EmpresaController::class, 'index']
)->name('pagina.lista.empresa');

Route::get('cadastro-empresa',
    [EmpresaController::class, 'create']
)->name('pagina.cadastro.empresa');

Route::get('editar-empresa/{id}', 
    [EmpresaController::class, 'edit']
)->name('pagina.editar.empresa');

Route::post('salvar-empresa', 
    [EmpresaController::class, 'store']
)->name('pagina.salvar.empresa');

Route::put('atualizar-empresa/{id}', 
    [EmpresaController::class, 'update']
)->name('pagina.atualizar.empresa');

Route::delete('deletar-empresa/{id}', 
    [EmpresaController::class, 'destroy']
)->name('pagina.deletar.empresa');