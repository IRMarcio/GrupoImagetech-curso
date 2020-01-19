<?php

namespace App\Models;

use App\Scopes\IgnorarTemporarioScope;
use phpDocumentor\Reflection\Types\Integer;
use SebastianBergmann\Comparator\NumericComparator;

class TabEndLocacao extends BaseModel
{
    protected $table = 'end_alocacao';

    protected $casts = [
        'ativo' => 'boolean'
    ];

    protected $fillable = [
        'centro_distribuicao_id',
        'armazem_id',
        'area',
        'rua',
        'modulo',
        'nivel',
        'vao',
        'produtos',
        'caixas',
        'paletes',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locacao()
    {
        return $this->belongsTo(TabEndArmazemCd::class, 'end_armazem_id', 'id');
    }

    /**
     * Retorna o Relação de Endereço do Centro de Distribuicao.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carga()
    {
        return $this->hasMany(EstocagemEndAlocacao::class, 'end_alocacao_id', 'id')->whereAtivo(1);
    }

    /**
     * Retorna o Soma de Total de Cargas deste endereço do Centro de Distribuicao.
     *
     * @return Integer;
     */
    public function getSomaQuantidadeCarga()
    {
        return $this->carga->map(function ($item) {
            return  $item->movimento->sum('quantidade_movimento') ;
        })->sum();
    }


    /**
     * Retorna o Relação de Endereço do Centro de Distribuicao.
     *
     * @return string
     */
    public function enderecoFormatado()
    {
        return
            $this->attributes['area'] . '-' .
            $this->attributes['rua'] . '-' .
            $this->attributes['modulo'] . '-' .
            $this->attributes['nivel'] . '-' .
            $this->attributes['vao'];

    }

}
