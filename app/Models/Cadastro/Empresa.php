<?php

namespace App\Models\Cadastro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresa';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'str_razao_social',
        'str_nome_fantasia',
        'str_cnpj',
        'str_inscricao_estadual',
        'str_inscricao_municipal',
        'str_email',
        'str_telefone',
        'str_celular',
        'str_logradouro',
        'int_numero',
        'str_complemento',
        'str_bairro',
        'str_cidade',
        'str_estado'
    ];
}
