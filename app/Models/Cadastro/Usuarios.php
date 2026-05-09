<?php

namespace App\Models\Cadastro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Usuarios extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'str_nome',
        'str_email',
        'str_password',
        'empresa_id',
        'grupo_id',
        'is_active'
    ];

    protected $hidden = [
        'str_password',
    ];

    public function getAuthPassword()
    {
        return $this->str_password;
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupos::class, 'grupo_id');
    }
}
