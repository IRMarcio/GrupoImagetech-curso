<?php

namespace App\Repositories;

use App\Models\CentroCurso;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;


class CentroCursosRepository extends CrudRepository
{

    protected $modelClass = CentroCurso::class;

    /**
     * @return Collection
     * *@see Faz Atualização do Banco de Cursos pertencentes ao Centro de distribuição educaional lotado;
     */
    public function geraGestaoCentroCusto()
    {
        /*Chama Função para limpesa de Cursos não mais utilizados sem relacionamento*/
        $this->cleanCursosNotInRelation();

        /*Executa funçao de Cadastro/Atualização do Curso Registrado no Centro*/
        foreach (request()->get('cursos') as $registro) {
            $registro = DB::transaction(function () use ($registro) {
                if (isset($registro['id']) && $this->findByID((int) $registro['id'])) {
                    return $this->findByID((int) $registro['id'])->update($registro);
                } else {
                    return $this->create($registro);
                }
            });
        }

        /** @var Collection $registro */
        return $registro;
    }

    /**
     * @see remove os Cursos tirados da lista de cadastro do Centro de distribuição sem (relação com alunos cadastrados);
     *
     * */
    private function cleanCursosNotInRelation()
    {
        /*Obtem os Ids que retirados da lista de cursos do centro*/
        $delete = array_diff(
            $this->getAll()->pluck('id')->toArray(),
            collect(request()->get('cursos'))->pluck('id')->toArray()
        );

        /*Resolve a função deletando Registros Localizados sem relacionamento*/
        $this->buscarVariosPorId($delete)->map(function ($item) {
            $item->delete();
        });

    }

}
