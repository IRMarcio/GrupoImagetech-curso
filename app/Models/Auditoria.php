<?php

namespace App\Models;

use App\Models\Usuario;

/**
 * Representa o model de auditoria no sistema.
 *
 * @package App\Models
 */
class Auditoria extends BaseModel
{

    /**
     * A tabela utilizada para este model.
     *
     * @var string
     */
    protected $table = 'auditoria';

    /**
     * Retorna descrição da ação.
     *
     * @return string
     */
    public function getDescricaoAcaoAttribute()
    {
        if ($this->descricao) {
            return $this->descricao;
        }

        if ($this->metodo === 'GET' && $this->rota->descricao_get) {
            return $this->rota->descricao_get;
        }

        if ($this->metodo === 'POST' && $this->rota->descricao_post) {
            return $this->rota->descricao_post;
        }

        return $this->rota->descricao;
    }

    /**
     * Todas as ações desta auditoria.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function acoes()
    {
        return $this->hasMany(AuditoriaAcao::class, 'auditoria_id', 'id')->orderBy('created_at', 'ASC')->orderBy('id', 'ASC');
    }

    /**
     * O tipo da rota.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo()
    {
        return $this->belongsTo(TipoRota::class, 'tipo_rota_id');
    }

    /**
     * A rota em que a ação foi executada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rota()
    {
        return $this->belongsTo(Rota::class, 'rota_id');
    }

    /**
     * Dados do usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
