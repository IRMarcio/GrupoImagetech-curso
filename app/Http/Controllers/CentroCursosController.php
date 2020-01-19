<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarCentroCursosRequest;
use App\Models\CentroCurso;
use App\Models\Curso;
use App\Relatorios\CentroCursosListagem;
use App\Relatorios\CursoListagem;
use App\Repositories\TipoPeriodoRepository;
use App\Repositories\CentroCursosRepository;

class CentroCursosController extends Controller
{

    /**
     * @var CursoListagem
     */
    private $listagem;

    /**
     * @var CentroCursosRepository
     */
    private $repository;

    /**
     * @var TipoPeriodoRepository
     */
    private $tipoPeriodoRepository;

    public function __construct(CentroCursosListagem $listagem, CentroCursosRepository $repository, TipoPeriodoRepository $tipoPeriodoRepository)
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
        $with = [];

        $filtros = request()->all();

        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros, $with);
        }

        $dados = $this->listagem->gerar($filtros, isset($filtros['paginar']) ? $filtros['paginar'] : true, $with);
        if (request()->wantsJson()) {
            return response()->json(['data' => $dados]);
        }

        $tipoPeriodos = $this->tipoPeriodoRepository->buscarTodosOrdenados('descricao');

        return view('centro_curso.index', compact('dados', 'filtros', 'tipoPeriodos'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $tipoPeriodos = $this->tipoPeriodoRepository->buscarTodosOrdenados('descricao');

        return view('centro_curso.adicionar', compact('tipoPeriodos'));
    }

    /**
     * Adiciona um novo registro.
     *
     *
     * @param  SalvarCentroCursosRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarCentroCursosRequest $request)
    {
        $registro = $this->repository->create($request->all());
        if (!$registro->id) {
            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'centro_curso', $registro);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param  Curso curso
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(CentroCurso $centroCurso)
    {
        $tipoPeriodos = $this->tipoPeriodoRepository->buscarTodosOrdenados('descricao');
        return view('centro_curso.alterar', compact('centroCurso', 'tipoPeriodos'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param  Curso  $registro
     *
     * @param  SalvarCentroCursosRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(Curso $registro, SalvarCentroCursosRequest $request)
    {

        $atualizado = $this->repository->update($registro, $request->all());
        if (!$atualizado) {
            return back()->withInput();
        }

        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'centro_curso', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param  Curso  $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function excluir(Curso $registro)
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
