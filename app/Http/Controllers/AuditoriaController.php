<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Rota;
use App\Models\TipoRota;
use App\Relatorios\AuditoriaListagem;
use App\Models\Usuario;

class AuditoriaController extends Controller
{

    /**
     * @var AuditoriaListagem
     */
    private $listagem;

    public function __construct(AuditoriaListagem $listagem)
    {
        parent::__construct();

        $this->listagem = $listagem;
    }

    /**
     * Lista todos os registros do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $filtros = request()->all();
        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }

        $dados = $this->listagem->gerar($filtros);

        $usuarios = Usuario::orderBy('nome');

        return view('auditoria.index', compact('dados', 'filtros', 'usuarios'));
    }

    /**
     * Visualizar detalhes de uma auditoria.
     *
     * @param Auditoria $auditoria
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function visualizar(Auditoria $auditoria)
    {
        $auditoria = $auditoria->load(['acoes', 'tipo', 'rota', 'usuario']);

        return view('auditoria.visualizar', compact('auditoria'));
    }
}
