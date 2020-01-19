<?php

namespace App\Relatorios;

use App\Models\Perfil;

class PerfilListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Perfis';

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
    protected $view = 'perfil.imprimir';

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
        $registros = Perfil::with($with)
                           ->select('perfil.*')
                           ->join('unidade', 'unidade.id', '=', 'perfil.unidade_id')
                           ->orderBy('unidade.descricao', 'ASC')
                           ->orderBy('perfil.nome', 'ASC');

        if (!empty($filtros['nome'])) {
            $registros->where('perfil.nome', 'LIKE', '%' . $filtros['nome'] . '%');
        }

        if (!empty($filtros['unidade_id'])) {
            $registros->whereIn('unidade_id', array_wrap($filtros['unidade_id']));
        }

        if (isset($filtros['ativo'])) {
            $registros->where('perfil.ativo', (int)$filtros['ativo']);
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }
}
