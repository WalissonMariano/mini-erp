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
        Schema::table('pedidos_venda', function (Blueprint $table) {
            $table->unsignedBigInteger('numero_pedido')->nullable()->after('id');
        });

        Schema::table('pedidos_compras', function (Blueprint $table) {
            $table->unsignedBigInteger('numero_pedido')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos_venda', function (Blueprint $table) {
            $table->dropColumn('numero_pedido');
        });

        Schema::table('pedidos_compras', function (Blueprint $table) {
            $table->dropColumn('numero_pedido');
        });
    }
};
