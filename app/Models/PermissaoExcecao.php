<?php

namespace App\Models;

class PermissaoExcecao extends BaseModel
{

    protected $table = 'excecao';

    protected $fillable = [
        'excecao',
        'perfil_usuario_id',
        'rota_id',
    ];
}