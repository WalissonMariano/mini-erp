<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos_venda', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresa')->onDelete('restrict');
            $table->uuid('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict');  
            $table->uuid('vendedor_id')->nullable();
            $table->foreign('vendedor_id')->references('id')->on('vendedores')->onDelete('restrict');
            $table->date('data_pedido');
            $table->string('status', 20)->default('rascunho');
            $table->text('str_observacao')->nullable();
            $table->decimal('dbl_valor_total', 12, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos_vendas');
    }
};
