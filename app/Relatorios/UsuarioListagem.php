<?php

namespace App\Relatorios;

use App\Services\Mascarado;
use App\Models\Usuario;

class UsuarioListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Usuários';

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
    protected $view = 'usuario.imprimir';

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
        $registros = Usuario::with($with)->orderBy('nome')->orderBy('cpf');

        if (!empty($filtros['nome'])) {
            $registros->where('nome', 'LIKE', '%' . $filtros['nome'] . '%');
        }

        if (!empty($filtros['usuario_id'])) {
            $ids = is_array($filtros['usuario_id']) ? $filtros['usuario_id'] : [$filtros['usuario_id']];
            $registros->whereIn('id', $ids);
        }

        if (!empty($filtros['cpf'])) {
            $registros->where('cpf', Mascarado::removerMascara($filtros['cpf']));
        }

        if (!empty($filtros['nuc_situacao_usuario_id'])) {
            $registros->whereHas('situacoes', function($q) use ($filtros) {
                $q->where('situacao_usuario_id', $filtros['nuc_situacao_usuario_id']);
            });
        }

        if (isset($filtros['admin']) && $filtros['admin'] == false) {
            $registros->where('super_admin', 0);
        }

        if (!empty($filtros['unidade_id'])) {
            $registros->whereHas('perfis', function ($q) use ($filtros) {
                $q->whereIn('unidade_id', array_wrap($filtros['unidade_id']));
            });
        }

        // Se usuário logado não for super_admin, ele não pode ver usuários super_admin
        if (auth()->user()->super_admin === false) {
            $registros->where('super_admin', false);
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }

        return $registros->get();
    }
}
