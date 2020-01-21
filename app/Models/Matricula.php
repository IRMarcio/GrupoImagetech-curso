<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Matricula extends BaseModel
{

    protected $with = ['centroCursos'];

    /*Status*/
    const ATIVA      = 1;
    const TRANCADA   = 3;
    const ABANDONO   = 2;
    const FINALIZADO = 4;

    public static $status = [
        self::ATIVA      => 'Ativa',
        self::TRANCADA   => 'Trancada',
        self::ABANDONO   => 'Abandono',
        self::FINALIZADO => 'Finalizado',
    ];

    protected $fillable = [
        'centro_cursos_id',
        'centro_distribuicao_id',
        'alunos_id',
        'ativo',
        'status',
    ];

    /**
     * @return  HasMany
     * *@see Retorna centro_curso ;
     */
    public function centroCursos()
    {
        return $this->HasMany(CentroCurso::class, 'id', 'centro_cursos_id');
    }

    /**
     * @return HasOne
     * *@see Retorna centro_curso;
     */
    public function alunos()
    {
        return $this->hasOne(Aluno::class, 'id', 'alunos_id');
    }

    /**
     * @return HasOne
     * *@see Retorna centro ;
     */
    public function centro()
    {
        return $this->hasOne(TabCentroDistribuicao::class, 'id', 'centro_distribuicao_id');
    }

    /**
     * @return array
     * *@see Retorna centro ;
     */
    public function getStatus($status)
    {
        return $this::$status[$this->attributes['status']];
    }
}
