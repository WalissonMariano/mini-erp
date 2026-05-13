<?php

namespace App\Models\Venda;

use App\Models\Estoque\Itens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidosVendaItens extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pedidos_vendas_itens';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'pedidos_venda_id',
        'itens_id',
        'dbl_quantidade',
        'dbl_valor_unitario',
        'dbl_valor_total',
    ];

    public function pedidoVenda()
    {
        return $this->belongsTo(PedidosVenda::class, 'pedidos_venda_id');
    }

    public function item()
    {
        return $this->belongsTo(Itens::class, 'itens_id');
    }
}
