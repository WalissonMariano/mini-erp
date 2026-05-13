<?php

namespace App\Models\Cadastro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fornecedores extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'str_nome',
        'str_cpf',
        'str_email',
        'str_telefone',
        'str_logradouro',
        'str_numero',
        'str_bairro',
        'str_cidade',
        'str_estado',
        'empresa_id'
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
