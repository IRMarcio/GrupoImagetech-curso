<?php

namespace App\Models;

class PerfilUsuario extends BaseModel
{

    protected $table = 'perfil_usuario';

    protected $casts = [
        'principal' => 'boolean',
        'ativo' => 'boolean'
    ];

    protected $fillable = [
        'principal',
        'ativo',
        'usuario_id',
        'perfil_id',
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
     * Retorna a usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
