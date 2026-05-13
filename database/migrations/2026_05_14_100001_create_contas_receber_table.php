<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contas_receber', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresa')->onDelete('restrict');
            $table->uuid('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict');
            $table->string('str_descricao', 255)->nullable();
            $table->decimal('dbl_valor', 12, 2)->default(0);
            $table->date('data_vencimento');
            $table->date('data_recebimento')->nullable();
            $table->string('status', 20)->default('aberto');
            $table->text('str_observacao')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contas_receber');
    }
};
