<?php

namespace App\Models;

use App\Scopes\IgnorarTemporarioScope;

class Unidade extends BaseModel
{
    protected $table = 'unidade';

    protected $casts = [
        'ativo' => 'boolean'
    ];

    protected $fillable = [
        'descricao',
        'ativo',
        'responsavel',
        'telefone',
        'fax',
        'email',
        'municipio_id',
        'endereco',
        'bairro',
        'numero',
        'complemento',
        'cep',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new IgnorarTemporarioScope);
    }

    /**
     * Retorna o município.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    /**
     * Todos as seções da unidade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function secoes()
    {
        return $this->hasMany(Secao::class, 'unidade_id');
    }

    /**
     * Todos os centro de distribuição que o relacionados a unidade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function centro()
    {
        return $this
            ->belongsToMany(TabCentroDistribuicao::class, 'unidade_centro_distribuicao')
            ->withTimestamps();
    }

    /**
     * Todos os centro de distribuição que o relacionados a unidade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function centroAtivo()
    {
        return $this->HasOne(UnidadeCentroDistribuicao::class, 'unidade_id');
    }
}
