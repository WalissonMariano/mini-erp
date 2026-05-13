<?php

namespace App\Models\Estoque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensEmbalagem extends Model
{
    use HasFactory;

    protected $table = 'itens_embalagens';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'item_id',
        'embalagem_id'
    ];

    public function item()
    {
        return $this->belongsTo(Itens::class, 'item_id');
    }

    public function embalagem()
    {
        return $this->belongsTo(Embalagens::class, 'embalagem_id');
    }
}
