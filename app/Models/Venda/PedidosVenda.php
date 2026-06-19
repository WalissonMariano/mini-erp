<?php

namespace App\Models\Venda;

use App\Models\Cadastro\Clientes;
use App\Models\Cadastro\Empresa;
use App\Models\Cadastro\Vendedores;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidosVenda extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_ABERTO = 'A';

    public const STATUS_BAIXADO = 'B';

    protected $table = 'pedidos_venda';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'empresa_id',
        'cliente_id',
        'vendedor_id',
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

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    public function vendedor()
    {
        return $this->belongsTo(Vendedores::class, 'vendedor_id');
    }

    public function itens()
    {
        return $this->hasMany(PedidosVendaItens::class, 'pedidos_venda_id');
    }

    public static function statusLabels(): array
    {
        return [
            self::STATUS_ABERTO => 'Aberto',
            self::STATUS_BAIXADO => 'Baixado',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status] ?? (string) $this->status;
    }

    public function isAberto(): bool
    {
        return $this->status === self::STATUS_ABERTO;
    }
}
