<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarMatriculaRequest as SalvarMatriculaRequestAlias;
use App\Models\Matricula;
use App\Relatorios\MatriculaListagem;
use App\Repositories\MatriculaRepository;

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

    public function __construct(MatriculaListagem $listagem, MatriculaRepository $repository)
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

        return view('matricula.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        return view('matricula.adicionar');
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
        return view('matricula.alterar', compact('matricula'));
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
}
