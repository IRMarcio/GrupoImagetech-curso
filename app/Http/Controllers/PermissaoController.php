<?php

namespace App\Http\Controllers;

use App\Services\GerenciaPermissoes;

class PermissaoController extends Controller
{

    /**
     * @var GerenciaPermissoes
     */
    private $gerenciaPermissoes;

    public function __construct(
      GerenciaPermissoes $gerenciaPermissoes
    )
    {
        parent::__construct();

        $this->gerenciaPermissoes = $gerenciaPermissoes;
    }

    /**
     * Retorna a lista dos registros.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $filtros = request()->all();
        $view = $this->gerenciaPermissoes->carregarViewGerenciamento($filtros);

        return response()->json(['data' => $view]);
    }

    /**
     * Atualiza as permissões.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function atualizar()
    {
        $dados = request()->all();
        $retorno = $this->gerenciaPermissoes->salvar($dados);

        return response()->json(['data' => $retorno]);
    }
}
