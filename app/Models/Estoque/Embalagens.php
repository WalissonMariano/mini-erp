<?php

namespace App\Models\Estoque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embalagens extends Model
{
    use HasFactory;

    protected $table = 'embalagens';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'str_sigla',
        'str_descricao',
        'dbl_quantidade_embalagem'
    ];

}
