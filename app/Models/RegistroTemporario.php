<?php

namespace App\Models;

class RegistroTemporario extends BaseModel
{

    protected $table = 'registro_temporario';

    protected $fillable = [
        'conteudo_id',
        'model',
    ];
}
