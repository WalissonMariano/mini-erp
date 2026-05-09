<?php

use App\Http\Controllers\Cadastro\UsuariosController;

Route::get('lista-usuarios', 
    [UsuariosController::class, 'index']
)->name('pagina.lista.usuarios');

Route::get('cadastro-usuarios',
    [UsuariosController::class, 'create']
)->name('pagina.cadastro.usuarios');

Route::get('editar-usuarios/{id}', 
    [UsuariosController::class, 'edit']
)->name('pagina.editar.usuarios');

Route::post('salvar-usuarios', 
    [UsuariosController::class, 'store']
)->name('pagina.salvar.usuarios');

Route::put('atualizar-usuarios/{id}', 
    [UsuariosController::class, 'update']
)->name('pagina.atualizar.usuarios');

Route::delete('deletar-usuarios/{id}', 
    [UsuariosController::class, 'destroy']
)->name('pagina.deletar.usuarios');