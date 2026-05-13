<?php

namespace App\Models\Financeiro;

use App\Models\Cadastro\Clientes;
use App\Models\Cadastro\Empresa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContasReceber extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'contas_receber';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'empresa_id',
        'cliente_id',
        'str_descricao',
        'dbl_valor',
        'data_vencimento',
        'data_recebimento',
        'status',
        'str_observacao',
    ];

    protected $casts = [
        'dbl_valor' => 'decimal:2',
        'data_vencimento' => 'date',
        'data_recebimento' => 'date',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }
}
