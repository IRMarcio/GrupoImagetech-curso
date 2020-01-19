<?php

namespace App\Models;

use App\Models\Perfil;
use App\Models\PermissaoExcecao;

class Rota extends BaseModel
{

    protected $table = 'rota';

    protected $fillable = [
        'descricao',
        'descricao_get',
        'descricao_post',
        'rota',
        'tipo_rota_id',
        'acesso_liberado',
        'desenv',
    ];

    /**
     * Todas os perfis que podem acessar esta rota.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'permissao', 'rota_id', 'perfil_id')->withTimestamps();
    }

    /**
     * Retorna o tipo da rota.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo()
    {
        return $this->belongsTo(TipoRota::class, 'tipo_rota_id');
    }

    /**
     * Excecoes de permissão ligadas a esta rota.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function excecoes()
    {
        return $this->hasMany(PermissaoExcecao::class, 'rota_id');
    }
}
