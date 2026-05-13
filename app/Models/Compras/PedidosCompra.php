<?php

namespace App\Models\Compras;

use App\Models\Cadastro\Empresa;
use App\Models\Cadastro\Fornecedores;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidosCompra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pedidos_compras';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'empresa_id',
        'fornecedores_id',
        'data_pedido',
        'status',
        'str_observacao',
        'dbl_valor_total',
    ];

    protected $casts = [
        'data_pedido' => 'date',
        'dbl_valor_total' => 'decimal:2',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedores::class, 'fornecedores_id');
    }

    public function itens()
    {
        return $this->hasMany(PedidosCompraItens::class, 'pedido_compra_id');
    }
}
