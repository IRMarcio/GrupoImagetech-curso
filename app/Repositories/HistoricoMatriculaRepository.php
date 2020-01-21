<?php

namespace App\Repositories;


use App\Models\HistoricoMatriculas;
use App\Models\Matricula;


class HistoricoMatriculaRepository extends CrudRepository
{

    protected $modelClass = HistoricoMatriculas::class;

    /**
     * @param  Matricula  $registro
     *
     * @see retorno store de Matrículas do aluno;
     */
    public function storeHistoriMatricula(Matricula $registro)
    {

        /*Salva Histórico no Banco */
        $this->create([
            'matricula_id'    => $registro->id,
            'centro_curso_id' => $registro->centro_cursos_id,
            'aluno_id'        => $registro->alunos_id,
            'status_anterior' => $registro->status,
            'status_atual'    => (int) request()->get('status'),
        ]);


        $value = (int) request()->get('status') === Matricula::ATIVA ? true : false;
        $registro->update(['ativo' => $value]);
    }

}
