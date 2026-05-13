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
        Schema::create('pedidos_vendas_itens', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->uuid('pedidos_venda_id');
            $table->foreign('pedidos_venda_id')->references('id')->on('pedidos_venda');
            $table->uuid('itens_id')->nullable();
            $table->foreign('itens_id')->references('id')->on('itens');
            $table->decimal('dbl_quantidade', 12, 2)->default(0);
            $table->decimal('dbl_valor_unitario', 12, 2)->default(0);
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
        Schema::dropIfExists('pedidos_vendas_itens');
    }
};
