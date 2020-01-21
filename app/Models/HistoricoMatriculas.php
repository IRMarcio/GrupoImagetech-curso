<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HistoricoMatriculas extends BaseModel
{

    protected $with =['centroCurso'];

    protected $table = 'historico_matricula_curso';

    protected $fillable = [
        'matricula_id',
        'centro_curso_id',
        'aluno_id',
        'status_anterior',
        'status_atual',
    ];

    /**
     * @see Retorno a Matrícula do Histórico do Aluno;
     *
     * @return HasOne
     */
    public function matricula()
    {
        return $this->hasOne(Matricula::class,'matricula_id');
    }

    /**
     * @see Retorno a Curso Cadastro dentro da Entidade de Ensino do Histórico do Aluno;
     *
     * @return HasOne
     */
    public function centroCurso()
    {
        return $this->hasOne(CentroCurso::class,'centro_cursos_id');
    }
    /**
     * @see Retorno a Curso Cadastro dentro da Entidade de Ensino do Histórico do Aluno;
     *
     * @return HasOne
     */
    public function aluno()
    {
        return $this->hasOne(Aluno::class,'aluno_id');
    }
}
