<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contas_pagar', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresa')->onDelete('restrict');
            $table->uuid('fornecedores_id')->nullable();
            $table->foreign('fornecedores_id')->references('id')->on('fornecedores')->onDelete('restrict');
            $table->string('str_descricao', 255)->nullable();
            $table->decimal('dbl_valor', 12, 2)->default(0);
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->string('status', 20)->default('aberto');
            $table->text('str_observacao')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contas_pagar');
    }
};
