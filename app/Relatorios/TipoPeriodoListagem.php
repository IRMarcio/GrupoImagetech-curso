<?php

namespace App\Relatorios;

use App\Models\TipoPeriodo;

class TipoPeriodoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Tipos de Produtos';

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
    protected $view = 'tipo_produto.imprimir';

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
        $registros = TipoPeriodo::orderBy('descricao', 'ASC');

        if (!empty($filtros['descricao'])) {
            $registros->where('descricao', 'LIKE', '%' . $filtros['descricao'] . '%');
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }
}
