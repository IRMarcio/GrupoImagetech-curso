<?php

namespace App\Models;

class Permissao extends BaseModel
{

    protected $table = 'permissao';

    protected $fillable = [
        'perfil_id',
        'rota_id',
    ];

    /**
     * Retorna o perfil.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }

    /**
     * Retorna a rota.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rota()
    {
        return $this->belongsTo(Rota::class, 'rota_id');
    }
}
