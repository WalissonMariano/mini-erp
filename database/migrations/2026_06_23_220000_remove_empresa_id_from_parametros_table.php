<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('parametros', 'empresa_id')) {
            return;
        }

        Schema::table('parametros', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropUnique(['empresa_id']);
            $table->dropColumn('empresa_id');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('parametros', 'empresa_id')) {
            return;
        }

        Schema::table('parametros', function (Blueprint $table) {
            $table->uuid('empresa_id')->nullable()->after('id');
            $table->foreign('empresa_id')->references('id')->on('empresa')->onDelete('restrict');
            $table->unique('empresa_id');
        });
    }
};
