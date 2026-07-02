<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    private const EMPRESA_ID = '00000000-0000-4000-8000-000000000001';

    private const GRUPO_ID = '00000000-0000-4000-8000-000000000002';

    private const USUARIO_ID = '00000000-0000-4000-8000-000000000003';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = now();

        if (! DB::table('empresa')->where('id', self::EMPRESA_ID)->exists()) {
            DB::table('empresa')->insert([
                'id' => self::EMPRESA_ID,
                'str_razao_social' => 'Empresa Padrão',
                'str_cnpj' => '00.000.000/0001-00',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (! DB::table('grupos')->where('id', self::GRUPO_ID)->exists()) {
            DB::table('grupos')->insert([
                'id' => self::GRUPO_ID,
                'str_nome' => 'Administrador',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (! DB::table('usuarios')->where('str_email', 'admin@admin.com')->exists()) {
            DB::table('usuarios')->insert([
                'id' => self::USUARIO_ID,
                'str_nome' => 'Administrador',
                'str_email' => 'admin@admin.com',
                'str_password' => Hash::make('123456'),
                'empresa_id' => self::EMPRESA_ID,
                'grupo_id' => self::GRUPO_ID,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('usuarios')->where('str_email', 'admin@admin.com')->delete();
    }
};
