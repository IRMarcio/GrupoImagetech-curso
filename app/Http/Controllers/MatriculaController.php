<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarMatriculaRequest as SalvarMatriculaRequestAlias;
use App\Models\Aluno;
use App\Models\CentroCurso;
use App\Models\Matricula;
use App\Relatorios\AlunoListagem;
use App\Relatorios\CentroCursosListagem;
use App\Relatorios\MatriculaListagem;
use App\Repositories\MatriculaRepository;
use App\Services\SessaoUsuario;

class MatriculaController extends Controller
{

    /**
     * @var MatriculaListagem
     */
    private $listagem;

    /**
     * @var MatriculaRepository
     */
    private $repository;

    /**
     * @var AlunoListagem
     */
    private $alunoListagem;

    /**
     * @var CentroCursosListagem
     */
    private $centroCursosListagem;

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(
        MatriculaListagem $listagem,
        MatriculaRepository $repository,
        AlunoListagem $alunoListagem,
        CentroCursosListagem $centroCursosListagem,
        SessaoUsuario $sessaoUsuario

    ) {
        parent::__construct();

        $this->listagem = $listagem;
        $this->repository = $repository;
        $this->alunoListagem = $alunoListagem;
        $this->centroCursosListagem = $centroCursosListagem;
        $this->sessaoUsuario = $sessaoUsuario;
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

        return view('matricula.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $alunos = $this->alunoListagem->gerar([], false);
        $centroCursos = $this->centroCursosListagem->gerar([], false);
        $statusAll = Matricula::$status;

        return view('matricula.adicionar', compact('alunos', 'centroCursos', 'statusAll'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param  SalvarMatriculaRequestAlias  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarMatriculaRequestAlias $request)
    {
        /*atualiza fluxo de cadastro inicial da matrícula no request*/
        $this->requestUpdateDadosStore($request);

        $registro = $this->repository->create($request->all());
        if (!$registro->id) {
            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'matricula', $registro);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param  Matricula  $matricula
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(Matricula $matricula)
    {
        $alunos = $this->alunoListagem->gerar([], false);
        $centroCursos = $this->centroCursosListagem->gerar([], false);
        $statusAll = Matricula::$status;

        return view('matricula.alterar', compact('matricula', 'centroCursos', 'alunos', 'statusAll'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param  Matricula  $registro
     * @param  SalvarMatriculaRequestAlias  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(Matricula $registro, SalvarMatriculaRequestAlias $request)
    {
        /*atualiza fluxo de cadastro inicial da matrícula no request*/
        $this->requestUpdateDadosStore($request, $request->get('status'));

        $atualizado = $this->repository->update($registro, $request->all());
        if (!$atualizado) {
            return back()->withInput();
        }

        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'matricula', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param  Matricula  $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function excluir(Matricula $registro)
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

    /**
     * @param $request
     *
     * @see Retorna fluxo de cadastro inicial de matricula no request;
     */
    private function requestUpdateDadosStore($request, $status = null)
    {
        $request->request->add(['centro_distribuicao_id' => $this->sessaoUsuario->centroDistribuicao()->id]);
        $request->request->add(['ativo' => true]);
        if (!$status) {
            $request->request->add(['status' => Matricula::EM_ANDAMENTO]);
        }
    }
}
