<?php

namespace App\Models\Estoque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Itens extends Model
{
    use HasFactory;

    protected $table = 'itens';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'str_codigo',
        'str_descricao',
        'dbl_preco',
        'categoria_id'
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function categoria()
    {
        return $this->belongsTo(ItensCategorias::class, 'categoria_id');
    }

    public function itensEmbalagens()
    {
        return $this->hasMany(ItensEmbalagem::class, 'item_id');
    }
}
