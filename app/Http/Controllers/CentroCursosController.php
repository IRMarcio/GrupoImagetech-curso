<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarCentroCursosRequest;
use App\Models\CentroCurso;
use App\Models\Curso;
use App\Relatorios\CentroCursosListagem;
use App\Relatorios\CursoListagem;
use App\Repositories\CursoRepository;
use App\Repositories\TipoPeriodoRepository;
use App\Repositories\CentroCursosRepository;
use App\Services\SessaoUsuario;
use Illuminate\Support\Facades\DB;

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

    /**
     * @var CursoRepository
     */
    private $cursoRepository;

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(
        CursoRepository $cursoRepository,
        CentroCursosListagem $listagem,
        CentroCursosRepository $repository,
        TipoPeriodoRepository $tipoPeriodoRepository,
        SessaoUsuario $sessaoUsuario
    ) {
        parent::__construct();

        $this->listagem = $listagem;
        $this->repository = $repository;
        $this->tipoPeriodoRepository = $tipoPeriodoRepository;
        $this->cursoRepository = $cursoRepository;
        $this->sessaoUsuario = $sessaoUsuario;
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
        $cursos = $this->cursoRepository->buscarTodosOrdenados('nome');
        $centro = $this->sessaoUsuario->centroDistribuicao();
        $centroCursos = $this->listagem->gerar([],false,false);

        return view('centro_curso.adicionar', compact('tipoPeriodos', 'cursos', 'centro', 'centroCursos'));
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
        $registro = $this->repository->geraGestaoCentroCusto($this->listagem->getClearCursosList());

        if (!$registro) {
            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'centro_curso', $registro);
    }


}
