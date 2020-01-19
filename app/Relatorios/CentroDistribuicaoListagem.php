<?php

namespace App\Relatorios;

use App\Models\TabCentroDistribuicao;
use App\Services\Mascarado;
use App\Models\Unidade;

class CentroDistribuicaoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Centro De Distribuição';

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
    protected $view = 'centro_distribuicao.imprimir';

    /**
     * Gera os dados.
     *
     * @param array $filtros
     * @param bool $paginar
     *
     * @return mixed
     */
    public function gerar($filtros, $paginar = true)
    {
        $registros = TabCentroDistribuicao::orderBy('descricao');

        if (!empty($filtros['descricao'])) {
            $registros->where('descricao', 'LIKE', '%' . $filtros['descricao'] . '%');
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }
}
