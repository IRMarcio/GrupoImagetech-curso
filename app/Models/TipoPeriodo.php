<?php

namespace App\Models;

class TipoPeriodo extends BaseModel
{


    protected $casts = [
        'ativo' => 'boolean',
        'permanente' => 'boolean',
    ];

    protected $fillable = [
        'descricao',
        'ativo',
        'permanente',
    ];
}
