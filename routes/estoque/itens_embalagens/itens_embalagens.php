<?php

use App\Http\Controllers\Estoque\ItensEmbalagensController;

Route::get('lista-itens-embalagens', 
    [ItensEmbalagensController::class, 'index']
)->name('pagina.lista.itens_embalagens');

Route::get('cadastro-itens-embalagens',
    [ItensEmbalagensController::class, 'create']
)->name('pagina.cadastro.itens_embalagens');

Route::get('editar-itens-embalagens/{id}', 
    [ItensEmbalagensController::class, 'edit']
)->name('pagina.editar.itens_embalagens');

Route::post('salvar-itens-embalagens', 
    [ItensEmbalagensController::class, 'store']
)->name('pagina.salvar.itens_embalagens');

Route::put('atualizar-itens-embalagens/{id}', 
    [ItensEmbalagensController::class, 'update']
)->name('pagina.atualizar.itens_embalagens');

Route::delete('deletar-itens-embalagens/{id}', 
    [ItensEmbalagensController::class, 'destroy']
)->name('pagina.deletar.itens_embalagens');