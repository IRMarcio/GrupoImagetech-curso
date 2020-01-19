<?php

namespace App\Relatorios;

use App\Services\Mascarado;
use App\Models\Aluno;

class AlunoListagem extends RelatorioBase
{

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
     * @param array $filtros
     * @param bool $paginar
     *
     * @return mixed
     */
    public function gerar($filtros, $paginar = true)
    {
        $registros = Aluno::orderBy('nome');
        if (!empty($filtros['nome'])) {
            $registros->where('nome', 'LIKE', '%' . $filtros['nome'] . '%');
        }

        if ($paginar) {
            return $registros->paginate($this->porPagina);
        }


        return $registros->get();
    }
}
