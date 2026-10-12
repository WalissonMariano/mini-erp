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
        $empresaId = $this->upsertEmpresa($now);
        $grupoId = $this->upsertGrupo($now);
        $this->upsertAdministrador($empresaId, $grupoId, $now);
    }

    private function upsertEmpresa($now): string
    {
        $dados = [
            'str_razao_social' => 'Fluxo Comércio e Distribuição Ltda',
            'str_nome_fantasia' => 'Fluxo',
            'str_cnpj' => '00.000.000/0001-00',
            'str_inscricao_estadual' => '123.456.789.012',
            'str_inscricao_municipal' => '9876543',
            'str_email' => 'contato@fluxo.demo',
            'str_telefone' => '(11) 3456-7890',
            'str_celular' => '(11) 98888-0000',
            'str_logradouro' => 'Avenida Paulista',
            'int_numero' => 1000,
            'str_complemento' => 'Conjunto 101',
            'str_bairro' => 'Bela Vista',
            'str_cidade' => 'São Paulo',
            'str_estado' => 'SP',
            'updated_at' => $now,
        ];

        $empresa = DB::table('empresa')->where('id', self::EMPRESA_ID)->first()
            ?? DB::table('empresa')->where('str_cnpj', $dados['str_cnpj'])->first();

        if ($empresa) {
            DB::table('empresa')->where('id', $empresa->id)->update($dados);

            return $empresa->id;
        }

        DB::table('empresa')->insert(array_merge($dados, [
            'id' => self::EMPRESA_ID,
            'created_at' => $now,
        ]));

        return self::EMPRESA_ID;
    }

    private function upsertGrupo($now): string
    {
        $grupo = DB::table('grupos')->where('id', self::GRUPO_ID)->first()
            ?? DB::table('grupos')->where('str_nome', 'Administrador')->first();

        if ($grupo) {
            DB::table('grupos')->where('id', $grupo->id)->update([
                'str_nome' => 'Administrador',
                'is_active' => true,
                'updated_at' => $now,
            ]);

            return $grupo->id;
        }

        DB::table('grupos')->insert([
            'id' => self::GRUPO_ID,
            'str_nome' => 'Administrador',
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return self::GRUPO_ID;
    }

    private function upsertAdministrador(string $empresaId, string $grupoId, $now): void
    {
        $dados = [
            'str_nome' => 'Administrador',
            'str_password' => Hash::make('123456'),
            'empresa_id' => $empresaId,
            'grupo_id' => $grupoId,
            'is_active' => true,
            'updated_at' => $now,
        ];

        $admin = DB::table('usuarios')->where('str_email', 'admin@admin.com')->first();

        if ($admin) {
            DB::table('usuarios')->where('id', $admin->id)->update($dados);

            return;
        }

        DB::table('usuarios')->insert(array_merge($dados, [
            'id' => self::USUARIO_ID,
            'str_email' => 'admin@admin.com',
            'created_at' => $now,
        ]));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('usuarios')->where('str_email', 'admin@admin.com')->delete();
    }
};
