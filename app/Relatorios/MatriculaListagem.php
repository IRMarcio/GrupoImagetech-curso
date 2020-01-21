<?php

namespace App\Relatorios;

use App\Models\Matricula;
use App\Relatorios\RelatorioBase;
use App\Models\Curso;
use App\Services\SessaoUsuario;

class MatriculaListagem extends RelatorioBase
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
    protected $titulo = 'MATRICULA';

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
    protected $view = 'matricula.imprimir';

    /**
     * Gera os dados.
     *
     * @param array $filtros
     * @param bool $paginar
     * @param array $with
     *
     * @return mixed
     */
    public function gerar($filtros, $paginar = true, $with = [])
    {
        $registros = Matricula::whereCentroDistribuicaoId($this->sessaoUsuario->centroDistribuicao()->id);

        if (!empty($filtros['aluno'])) {
            $registros->whereHas('alunos', function ($q) use ($filtros) {
                $q->where('nome', 'like', '%'.$filtros['aluno'].'%');
            });
        }

        if (!empty($filtros['curso'])) {
            $registros->whereHas('centroCursos', function ($q) use ($filtros) {
                $q->whereHas('curso', function ($q) use ($filtros) {
                   $q->where('nome', 'like', '%'.$filtros['curso'].'%');
                });
            });
        }

        if (!empty($filtros['periodo'])) {
            $registros->whereHas('centroCursos', function ($q) use ($filtros) {
                $q->where('tipo_periodo_id',(int)$filtros['periodo']);
            });
        }

        if (!empty($filtros['turma'])) {
            $registros->whereHas('centroCursos.curso', function ($q) use ($filtros) {
                $q->whereYear('data_inicio', 'like', '%'.$filtros['turma'].'%');
            });
        }

        if (!empty($filtros['status'])) {
            $registros->where( function ($q) use ($filtros) {
                $q->where('status', $filtros['status']);
            });
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }
        return $registros->get();
    }
}
