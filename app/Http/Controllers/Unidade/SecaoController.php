<?php

namespace App\Http\Controllers\Unidade;

use App\Http\Controllers\Controller;
use DB;
use App\Models\Unidade;
use App\Models\Secao;
use App\Services\GerenciaUnidadeSecao;
use App\Relatorios\SecaoListagem;

class SecaoController extends Controller
{
    /**
     * @var GerenciaUnidadeSecao
     */
    private $gerenciaUnidadeSecao;

    public function __construct(GerenciaUnidadeSecao $gerenciaUnidadeSecao, SecaoListagem $listagem)
    {
        $this->gerenciaUnidadeSecao = $gerenciaUnidadeSecao;
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

        $dados = $this->listagem->gerar($filtros, isset($filtros['paginar']) ? $filtros['paginar'] : true);
        
        return response()->json(['data' => $dados]);
    }

    /**
     * Adiciona um novo registro.
     *
     * @param Unidade $unidade
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function salvar(Unidade $unidade)
    {
        $registro = DB::transaction(function () use ($unidade) {
            return $this->gerenciaUnidadeSecao->criar($unidade, request()->all());
        });

        if (!$registro) {
            return response()->json(['data' => false]);
        }

        return response()->json(['data' => $registro]);
    }

    /**
     * Altera os dados de um registro.
     *
     * @param Secao $secao
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function atualizar(Secao $secao)
    {
        $registro = DB::transaction(function () use ($secao) {
            return $this->gerenciaUnidadeSecao->alterar($secao->id, request()->all());
        });

        if (!$registro) {
            return response()->json(['data' => false]);
        }

        return response()->json(['data' => $registro]);
    }

    /**
     * Exclui seção.
     *
     * @param Secao $secao
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function excluir(Secao $secao)
    {
        $excluido = $secao->delete();
        if (!$excluido) {
            return response()->json(['data' => false]);
        }

        return response()->json(['data' => true]);
    }

    /**
     * Validar exclusão de seção.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function validarExclusao()
    {
        $secao = Secao::findOrFail(request()->get('secao_id'));
        
        return response()->json(['data' => $secao->produtosEstoque->count() ? false : true]);
    }
}
