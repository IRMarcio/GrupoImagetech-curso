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


        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }
}
