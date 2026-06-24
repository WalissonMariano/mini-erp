<?php

namespace App\Models\Configuracao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Parametros extends Model
{
    use HasFactory;

    protected $table = 'parametros';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'is_gera_financeiro',
    ];

    protected $casts = [
        'is_gera_financeiro' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function geraFinanceiro(): bool
    {
        return (bool) $this->is_gera_financeiro;
    }

    public static function configuracao(): self
    {
        return static::query()->firstOrCreate([], [
            'is_gera_financeiro' => false,
        ]);
    }
}
