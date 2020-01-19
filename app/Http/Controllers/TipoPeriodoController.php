<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarTipoPeriodoRequest;
use App\Models\TipoPeriodo;
use App\Relatorios\TipoPeriodoListagem;
use App\Repositories\TipoPeriodoRepository;

class TipoPeriodoController extends Controller
{

    /**
     * @var TipoPeriodoListagem
     */
    private $listagem;

    /**
     * @var TipoPeriodoRepository
     */
    private $repository;

    public function __construct(TipoPeriodoListagem $listagem, TipoPeriodoRepository $repository)
    {
        parent::__construct();

        $this->listagem = $listagem;
        $this->repository = $repository;
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

        return view('tipo_periodo.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        return view('tipo_periodo.adicionar');
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarTipoPeriodoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarTipoPeriodoRequest $request)
    {
        $registro = $this->repository->create($request->all());
        if (!$registro->id) {
            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'tipo_periodo', $registro);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param TipoPeriodo $tipoPeriodo
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(TipoPeriodo $tipoPeriodo)
    {
        return view('tipo_periodo.alterar', compact('tipoPeriodo'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param  TipoPeriodo  $registro
     *
     * @param  SalvarTipoPeriodoRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(TipoPeriodo $registro, SalvarTipoPeriodoRequest $request)
    {
        $atualizado = $this->repository->update($registro, $request->all());
        if (!$atualizado) {
            return back()->withInput();
        }

        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'tipo_periodo', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param TipoPeriodo $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function excluir(TipoPeriodo $registro)
    {
        $excluido = $this->repository->delete($registro);
        if (!$excluido) {
            return back()->withInput();
        }

        flash('O registro foi excluído com sucesso.')->success();

        return redirect()->back();
    }

    /**
     * Exclui um ou mais registros selecionados.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function excluirVarios()
    {
        $registros = $this->repository->buscarVariosPorId(request('ids'));
        $excluido = $this->excluirVariosRegistros($registros);
        if (!$excluido) {
            return response()->json(['sucesso' => false]);
        }

        flash('Os registros foram excluídos com sucesso.')->success();

        return response()->json(['sucesso' => true]);
    }
}
