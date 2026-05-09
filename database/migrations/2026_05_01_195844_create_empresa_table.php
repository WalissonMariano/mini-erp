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
        Schema::create('empresa', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('str_razao_social', 150);
            $table->string('str_nome_fantasia', 150)->nullable();
            $table->string('str_cnpj', 18)->unique();
            $table->string('str_inscricao_estadual', 30)->nullable();
            $table->string('str_inscricao_municipal', 30)->nullable();
            $table->string('str_email', 120)->nullable();
            $table->string('str_telefone', 20)->nullable();
            $table->string('str_celular', 20)->nullable();
            $table->string('str_logradouro', 200)->nullable();
            $table->integer('int_numero')->nullable();
            $table->string('str_complemento', 120)->nullable();
            $table->string('str_bairro', 120)->nullable();
            $table->string('str_cidade', 120)->nullable();
            $table->string('str_estado', 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
