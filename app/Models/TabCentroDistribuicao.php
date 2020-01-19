<?php

namespace App\Models;

use App\Scopes\IgnorarTemporarioScope;

class TabCentroDistribuicao extends BaseModel
{
    protected $table = 'centro_distribuicao';

    const MATRIZ = 1;


    protected $casts = [
        'ativo' => 'boolean'
    ];

    protected $fillable = [
        'descricao',
        'ativo',
        'responsavel',
        'matriz',
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
     * Retorna o Relação de Endereço do Centro de Distribuicao.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function endereco()
    {
        return $this->hasOne(TabEndereco::class,'centro_distribuicao_id');
    }


    /**
     * Todos as seções da unidade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function armazem()
    {
        return $this->hasMany(TabArmazem::class, 'centro_distribuicao_id')->with(['endereco.municipio.uf']);
    }

    /**
     * Todos as seções da unidade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function endAlocacao()
    {
        return $this->hasMany(TabEndLocacao::class, 'centro_distribuicao_id');
    }

    public function estoqueInventario()
    {
        return $this->hasMany(EstoqueInventario::class, 'centro_distribuicao_id');
    }

    /**
     * Retorna o Relação de Endereço do Centro de Distribuicao.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function unidadeCentro()
    {
        return $this->belongsToMany(Unidade::class,'unidade_centro_distribuicao');
    }
}
