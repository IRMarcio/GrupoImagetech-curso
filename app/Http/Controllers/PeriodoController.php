<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarPeriodoRequest;
use App\Models\Periodo;
use App\Relatorios\PeriodoListagem;
use App\Repositories\TipoPeriodoRepository;
use App\Repositories\PeriodoRepository;

class PeriodoController extends Controller
{

    /**
     * @var PeriodoListagem
     */
    private $listagem;

    /**
     * @var PeriodoRepository
     */
    private $repository;

    /**
     * @var TipoPeriodoRepository
     */
    private $tipoPeriodoRepository;

    public function __construct(PeriodoListagem $listagem, PeriodoRepository $repository, TipoPeriodoRepository $tipoPeriodoRepository)
    {
        parent::__construct();

        $this->listagem = $listagem;
        $this->repository = $repository;
        $this->tipoPeriodoRepository = $tipoPeriodoRepository;
    }

    /**
     * Lista todos os registros do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $with = ['tipoPeriodo'];

        $filtros = request()->all();

        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros, $with);
        }

        $dados = $this->listagem->gerar($filtros, isset($filtros['paginar']) ? $filtros['paginar'] : true, $with);
        if (request()->wantsJson()) {
            return response()->json(['data' => $dados]);
        }

        $tipoPeriodos = $this->tipoPeriodoRepository->buscarTodosOrdenados('descricao');

        return view('periodo.index', compact('dados', 'filtros', 'tipoPeriodos'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $tipoPeriodos = $this->tipoPeriodoRepository->buscarTodosOrdenados('descricao');

        return view('periodo.adicionar', compact('tipoPeriodos'));
    }

    /**
     * Adiciona um novo registro.
     *
     *
     * @param  SalvarPeriodoRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarPeriodoRequest $request)
    {
        $registro = $this->repository->create($request->all());
        if (!$registro->id) {
            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'periodo', $registro);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param Periodo $periodo
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(Periodo $periodo)
    {
        $tipoPeriodos = $this->tipoPeriodoRepository->buscarTodosOrdenados('descricao');

        return view('periodo.alterar', compact('periodo', 'tipoPeriodos'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param  Periodo  $registro
     *
     * @param  SalvarPeriodoRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(Periodo $registro, SalvarPeriodoRequest $request)
    {
        $atualizado = $this->repository->update($registro, $request->all());
        if (!$atualizado) {
            return back()->withInput();
        }

        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'periodo', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param Periodo $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function excluir(Periodo $registro)
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
