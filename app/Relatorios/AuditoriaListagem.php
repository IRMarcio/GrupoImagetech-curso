<?php

namespace App\Relatorios;

use App\Models\Auditoria;

class AuditoriaListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Auditoria';

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
    protected $view = 'auditoria.imprimir';

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
        $auditoria = Auditoria::with(['acoes', 'tipo', 'rota', 'usuario'])
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC');

        if (!empty($filtros['usuario_id'])) {
            $auditoria->where('usuario_id', $filtros['usuario_id']);
        }

        if (!empty($filtros['descricao_acao'])) {
            $auditoria->whereHas('rota', function($q) use ($filtros) {
                $q->where('descricao', 'like', '%' . $filtros['descricao_acao'] . '%');
                $q->orWhere('descricao_get', 'like', '%' . $filtros['descricao_acao'] . '%');
                $q->orWhere('descricao_post', 'like', '%' . $filtros['descricao_acao'] . '%');
            })->orWhere('descricao', 'like', '%' . $filtros['descricao_acao'] . '%');
        }

        if (!empty($filtros['data'])) {
            $data = formatarData($filtros['data'], 'Y-m-d');
            $auditoria->whereDate("created_at", $data);
        }

        if ($paginar) {
            return $auditoria->paginate($this->porPagina);
        }

        return $auditoria->get();
    }
}
