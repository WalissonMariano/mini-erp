<?php 

use App\Http\Controllers\Cadastro\ClientesController;

Route::get('lista-clientes', 
    [ClientesController::class, 'index']
)->name('pagina.lista.clientes');

Route::get('novo-cliente', 
    [ClientesController::class, 'create']
)->name('pagina.novo.cliente');

Route::get('editar-cliente/{id}', 
    [ClientesController::class, 'edit']
)->name('pagina.editar.cliente');

Route::post('armazenar-cliente', 
    [ClientesController::class, 'store']
)->name('pagina.armazenar.cliente');

Route::put('atualizar-cliente/{id}', 
    [ClientesController::class, 'update']
)->name('pagina.atualizar.cliente');

Route::delete('deletar-cliente/{id}', 
    [ClientesController::class, 'destroy']
)->name('pagina.deletar.cliente');