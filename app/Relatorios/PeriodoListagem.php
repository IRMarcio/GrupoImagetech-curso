<?php

namespace App\Relatorios;

use App\Relatorios\RelatorioBase;
use App\Models\Periodo;

class PeriodoListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'PERÍODO';

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
    protected $view = 'periodo.imprimir';

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
        $registros = Periodo::select('periodos.*')
                              ->with($with)
                              ->leftJoin('tipo_periodos', 'tipo_periodos.id', '=', 'periodos.tipo_periodo_id')
                              ->orderBy('periodos.descricao', 'ASC')
                              ->orderBy('tipo_periodos.descricao', 'ASC');

        if (!empty($filtros['descricao'])) {
            $registros->where('periodos.descricao', 'LIKE', '%' . $filtros['descricao'] . '%');
        }

        if (!empty($filtros['tipo_periodo_id'])) {
            $registros->where('periodos.tipo_produto_id', $filtros['tipo_periodo_id']);
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }
}
