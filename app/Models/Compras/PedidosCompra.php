<?php

namespace App\Models\Compras;

use App\Models\Cadastro\Empresa;
use App\Models\Cadastro\Fornecedores;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PedidosCompra extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_ABERTO = 'A';

    public const STATUS_BAIXADO = 'B';

    protected $table = 'pedidos_compras';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'numero_pedido',
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
        'numero_pedido' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

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

    public static function proximoNumeroPedido(): int
    {
        $ultimo = static::withTrashed()
            ->whereNotNull('numero_pedido')
            ->orderByDesc('numero_pedido')
            ->lockForUpdate()
            ->value('numero_pedido');

        return (int) ($ultimo ?? 0) + 1;
    }
}
