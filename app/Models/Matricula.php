<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Matricula extends BaseModel
{

    /*Status*/
    const EM_ANDAMENTO = 1;
    const TRANCADA     = 3;
    const ABANDONO     = 2;
    const FINALIZADO   = 4;

    public static $status = [
        self::EM_ANDAMENTO => 'Em Andamento',
        self::TRANCADA     => 'Trancada',
        self::ABANDONO     => 'Abandono',
        self::FINALIZADO   => 'Finalizado',
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
        return $this->HasMany(CentroCurso::class,'id', 'centro_cursos_id');
    }


    /**
     * @return  HasMany
     * *@see Retorna centro_curso;
     */
    public function alunos()
    {
        return $this->HasMany(Aluno::class,'id', 'alunos_id');
    }

    /**
     * @return HasOne
     * *@see Retorna centro ;
     */
    public function centro()
    {
        return $this->hasOne(TabCentroDistribuicao::class,'id', 'centro_distribuicao_id');
    }
}
