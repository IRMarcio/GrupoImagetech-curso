<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

class CentroCurso extends BaseModel
{

    protected $with =['curso', 'periodo'];

    protected $fillable =
        [
            'centro_distribuicao_id',
            'curso_id',
            'tipo_periodo_id',
            'quantidade_vagas',
            'data_inicio',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * *@see Retorna o Centro de Distribuição relacionada;
     *
     */
    public  function matricula()
    {
        return $this->HasMany(Matricula::class, 'centro_cursos_id');
    }
    /**
     * @see Retorna o Curso relacionada;
     *
     * @return HasOne
     * */
    public  function curso()
    {
        return $this->hasOne(Curso::class, 'id','curso_id');
    }

    /**
     * @see Retorna o Período relacionado;
     *
     * @return HasOne
     * */
    public  function periodo()
    {
        return $this->hasOne(TipoPeriodo::class,'id', 'tipo_periodo_id');
    }
}
