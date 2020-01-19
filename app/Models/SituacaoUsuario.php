<?php

namespace App\Models;

class SituacaoUsuario extends BaseModel
{

    protected $table = 'situacao_usuario';

    protected $fillable = [
        'descricao',
        'slug',
    ];
    
}
