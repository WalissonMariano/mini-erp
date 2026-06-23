<?php

namespace App\Models\Compras;

use App\Models\Estoque\Itens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PedidosCompraItens extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pedidos_compras_itens';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'pedido_compra_id',
        'item_id',
        'dbl_quantidade',
        'dbl_valor_unitario',
        'dbl_valor_total',
    ];

    protected $casts = [
        'dbl_quantidade' => 'decimal:2',
        'dbl_valor_unitario' => 'decimal:2',
        'dbl_valor_total' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function pedidoCompra()
    {
        return $this->belongsTo(PedidosCompra::class, 'pedido_compra_id');
    }

    public function item()
    {
        return $this->belongsTo(Itens::class, 'item_id');
    }
}
