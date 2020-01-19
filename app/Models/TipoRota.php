<?php

namespace App\Models;

class TipoRota extends BaseModel
{

    protected $table = 'tipo_rota';

    protected $fillable = [
        'descricao'
    ];

    /**
     * Retorna todas as rotas deste tipo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rotas()
    {
        return $this->hasMany(Rota::class, 'tipo_rota_id');
    }
}
