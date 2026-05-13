<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('str_nome', 150);
            $table->string('str_cpf', 14)->unique();
            $table->string('str_email', 120)->unique();
            $table->string('str_telefone', 20);
            $table->string('str_logradouro', 255);
            $table->string('str_numero', 10);
            $table->string('str_bairro', 100);
            $table->string('str_cidade', 100);
            $table->string('str_estado', 50);
            $table->uuid('empresa_id')->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresa');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};
