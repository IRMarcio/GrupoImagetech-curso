<?php

namespace App\Relatorios;

use App\Models\CentroCurso;
use App\Relatorios\RelatorioBase;
use App\Models\Curso;
use App\Services\SessaoUsuario;

class CentroCursosListagem extends RelatorioBase
{

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(SessaoUsuario $sessaoUsuario)
    {
        $this->sessaoUsuario = $sessaoUsuario;
    }

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Centro Cursos Disponíveis';

    /**
     * Quantidade de itens por página.
     *
     * @var int
     */
    protected $porPagina = 10;

    /**
     * A view utilizada para impressão deste relatório.
     *
     * @var string
     */
    protected $view = 'centro_curso.imprimir';

    /**
     * Gera os dados.
     *
     * @param  array  $filtros
     * @param  bool  $paginar
     * @param  array  $with
     *
     * @return mixed
     */
    public function gerar($filtros = [], $paginar = true, $with = [])
    {
        $registros = CentroCurso::with('matricula')->whereCentroDistribuicaoId($this->sessaoUsuario->centroDistribuicao()->id);

        if (!empty($filtros['descricao'])) {
            $registros->where('descricao', 'LIKE', '%'.$filtros['descricao'].'%');
        }

        if (!empty($filtros['curso'])) {
            $registros->whereHas('curso', function ($q) use ($filtros) {
                $q->where('nome', 'like', '%'.$filtros['curso'].'%');
            });
        }
        if (!empty($filtros['turma'])) {
            $registros->whereHas('curso', function ($q) use ($filtros) {
                $q->whereYear('data_inicio', 'like', '%'.$filtros['turma'].'%');
            });
        }

        if (!empty($filtros['tipo_periodo_id'])) {
            $registros->where('tipo_periodo_id', (int) $filtros['tipo_periodo_id']);
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }

    /**
     *
     * */
    public function getClearCursosList()
    {
        /*Obtem os Ids que retirados da lista de cursos do centro*/
        return array_diff(
            CentroCurso::whereCentroDistribuicaoId($this->sessaoUsuario->centroDistribuicao()->id)->pluck('id')->toArray(),
            collect(request()->get('cursos'))->pluck('id')->toArray()
        );
    }
}
