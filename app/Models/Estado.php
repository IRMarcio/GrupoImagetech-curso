<?php

namespace App\Models;

class Estado extends BaseModel
{
    protected $table = 'uf';

    protected $fillable = [
        'descricao',
        'uf',
    ];
}
