<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

class CentroCurso extends BaseModel
{

    protected $fillable =
        [
            'centro_distribuicao_id',
            'curso_id',
            'tipo_periodo_id',
            'quantidade_vagas',
        ];


    /**
     * @see Retorna o Centro de Distribuição relacionada;
     *
     * @return HasOne
     * */
    public  function centro()
    {
        return $this->hasOne(TabCentroDistribuicao::class, 'centro_distribuicao_id');
    }
    /**
     * @see Retorna o Curso relacionada;
     *
     * @return HasOne
     * */
    public  function curso()
    {
        return $this->hasOne(Curso::class, 'curso_id');
    }

    /**
     * @see Retorna o Período relacionado;
     *
     * @return HasOne
     * */
    public  function periodo()
    {
        return $this->hasOne(TipoPeriodo::class, 'tipo_periodo_id');
    }
}
