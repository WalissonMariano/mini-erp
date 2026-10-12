<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $parametro = DB::table('parametros')->orderBy('created_at')->first();

        if ($parametro) {
            DB::table('parametros')->where('id', $parametro->id)->update([
                'is_gera_financeiro' => true,
                'updated_at' => now(),
            ]);

            return;
        }

        DB::table('parametros')->insert([
            'id' => (string) Str::uuid(),
            'is_gera_financeiro' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('parametros')->update([
            'is_gera_financeiro' => false,
            'updated_at' => now(),
        ]);
    }
};
