<?php

namespace App\Repositories;

use App\Models\CentroCurso;
use App\Services\SessaoUsuario;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;


class CentroCursosRepository extends CrudRepository
{

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(SessaoUsuario $sessaoUsuario)
    {
        $this->sessaoUsuario = $sessaoUsuario;
    }

    protected $modelClass = CentroCurso::class;

    /**
     * @return Collection
     * *@see Faz Atualização do Banco de Cursos pertencentes ao Centro de distribuição educaional lotado;
     */
    public function geraGestaoCentroCusto($validation)
    {
        /*Chama Função para limpesa de Cursos não mais utilizados sem relacionamento*/
        $this->cleanCursosNotInRelation($validation);

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
    private function cleanCursosNotInRelation($delete)
    {

        /*Resolve a função deletando Registros Localizados sem relacionamento*/
        $this->buscarVariosPorId($delete)->map(function ($item) {
            $item->delete();
        });

    }

}
