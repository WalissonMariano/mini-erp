<?php

namespace App\Models\Cadastro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'str_nome',
        'str_descricao',
        'is_active',
    ];
}
