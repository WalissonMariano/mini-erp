<?php

namespace App\Models\Estoque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
