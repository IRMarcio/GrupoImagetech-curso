<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarEstadoRequest;
use App\Models\Estado;
use App\Relatorios\EstadoListagem;
use App\Repositories\EstadoRepository;

class EstadoController extends Controller
{

    /**
     * @var EstadoListagem
     */
    private $listagem;

    /**
     * @var EstadoRepository
     */
    private $repository;

    public function __construct(EstadoListagem $listagem, EstadoRepository $repository)
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

        return view('estado.index', compact('dados', 'filtros'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        return view('estado.adicionar');
    }

    /**
     * Adiciona um novo registro.
     *
     * @param SalvarEstadoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarEstadoRequest $request)
    {
        $registro = $this->repository->create($request->all());
        if (!$registro->id) {
            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'estado', $registro);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param Estado $estado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(Estado $estado)
    {
        return view('estado.alterar', compact('estado'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param Estado $registro
     * @param \Modules\Nucleo\Http\Requests\SalvarEstadoRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(Estado $registro, SalvarEstadoRequest $request)
    {
        $atualizado = $this->repository->update($registro, $request->all());
        if (!$atualizado) {
            return back()->withInput();
        }

        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'estado', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param Estado $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function excluir(Estado $registro)
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
