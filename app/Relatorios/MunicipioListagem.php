<?php

namespace App\Relatorios;

use App\Relatorios\RelatorioBase;
use App\Models\Municipio;

class MunicipioListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Municípios';

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
    protected $view = 'municipio.imprimir';

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
        $registros = Municipio::select('municipio.*')
                              ->with($with)
                              ->join('uf', 'uf.id', '=', 'municipio.uf_id')
                              ->orderBy('municipio.descricao', 'ASC')
                              ->orderBy('uf.descricao', 'ASC');

        if (!empty($filtros['descricao'])) {
            $registros->where('municipio.descricao', 'LIKE', '%' . $filtros['descricao'] . '%');
        }

        if (!empty($filtros['uf_id'])) {
            $registros->where('municipio.uf_id', $filtros['uf_id']);
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }
}
