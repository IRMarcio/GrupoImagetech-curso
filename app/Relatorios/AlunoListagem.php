<?php

namespace App\Relatorios;

use App\Services\Mascarado;
use App\Models\Aluno;
use App\Services\SessaoUsuario;

class AlunoListagem extends RelatorioBase
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
    protected $titulo = 'Alunos';

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
    protected $view = 'aluno.imprimir';

    /**
     * Gera os dados.
     *
     * @param  array  $filtros
     * @param  bool  $paginar
     *
     * @return mixed
     */
    public function gerar($filtros, $paginar = true)
    {
        /*Busca Centro de Distribuicao Estudantil na Sessão do Usuario Atual*/
        $centro = $this->sessaoUsuario->centroDistribuicao();
        //dd($centro);
        /*Retorna query com os alunos do Centro Atual*/
        $registros = Aluno::whereCentroDistribuicaoId($centro->id)
                          ->orderBy('nome');

        if (!empty($filtros['nome'])) {
            $registros->where('nome', 'LIKE', '%'.$filtros['nome'].'%');
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }


        return $registros->get();
    }
}
