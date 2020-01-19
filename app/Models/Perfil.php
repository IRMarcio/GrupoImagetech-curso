<?php

namespace App\Models;

class Perfil extends BaseModel
{
    protected $table = 'perfil';

    protected $fillable = [
        'nome',
        'ativo',
        'unidade_id',
    ];

    /**
     * Retorna as permissões do perfil.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissoes()
    {
        return $this->belongsToMany(Rota::class, 'permissao', 'perfil_id', 'rota_id')->withTimestamps();
    }

    /**
     * Retorna a unidade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }
}
