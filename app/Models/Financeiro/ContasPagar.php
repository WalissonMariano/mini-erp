<?php

namespace App\Models\Financeiro;

use App\Models\Cadastro\Empresa;
use App\Models\Cadastro\Fornecedores;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContasPagar extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'contas_pagar';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'empresa_id',
        'fornecedores_id',
        'str_descricao',
        'dbl_valor',
        'data_vencimento',
        'data_pagamento',
        'status',
        'str_observacao',
    ];

    protected $casts = [
        'dbl_valor' => 'decimal:2',
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedores::class, 'fornecedores_id');
    }
}
