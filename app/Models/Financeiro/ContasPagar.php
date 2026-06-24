<?php

namespace App\Models\Financeiro;

use App\Models\Cadastro\Empresa;
use App\Models\Cadastro\Fornecedores;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ContasPagar extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_ABERTO = 'aberto';

    public const STATUS_PAGO = 'pago';

    public const STATUS_CANCELADO = 'cancelado';

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

    public static function statusLabels(): array
    {
        return [
            self::STATUS_ABERTO => 'Aberto',
            self::STATUS_PAGO => 'Pago',
            self::STATUS_CANCELADO => 'Cancelado',
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
