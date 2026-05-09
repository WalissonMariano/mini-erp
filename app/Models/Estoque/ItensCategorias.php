<?php

namespace App\Models\Estoque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensCategorias extends Model
{
    use HasFactory;

    protected $table = 'itens_categorias';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'str_descricao'
    ];
}
