<?php

namespace App\Relatorios;

use App\Models\Estado;

class EstadoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Estados';

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
    protected $view = 'estado.imprimir';

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
        $registros = Estado::orderBy('descricao', 'ASC');

        if (!empty($filtros['descricao'])) {
            $registros->where('descricao', 'LIKE', '%' . $filtros['descricao'] . '%');
        }

        if (!empty($filtros['uf'])) {
            $registros->where('uf', $filtros['uf']);
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }
}
