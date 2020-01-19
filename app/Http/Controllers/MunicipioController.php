<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalvarMunicipioRequest;
use App\Models\Municipio;
use App\Relatorios\MunicipioListagem;
use App\Repositories\EstadoRepository;
use App\Repositories\MunicipioRepository;

class MunicipioController extends Controller
{

    /**
     * @var MunicipioListagem
     */
    private $listagem;

    /**
     * @var MunicipioRepository
     */
    private $repository;

    /**
     * @var EstadoRepository
     */
    private $estadoRepository;

    public function __construct(MunicipioListagem $listagem, MunicipioRepository $repository, EstadoRepository $estadoRepository)
    {
        parent::__construct();

        $this->listagem = $listagem;
        $this->repository = $repository;
        $this->estadoRepository = $estadoRepository;
    }

    /**
     * Lista todos os registros do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $with = ['uf'];

        $filtros = request()->all();

        if (!isset($filtros['uf_id'])) {
            $filtros['uf_id'] = session('uf_id');
        }

        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros, $with);
        }

        $dados = $this->listagem->gerar($filtros, isset($filtros['paginar']) ? $filtros['paginar'] : true, $with);
        if (request()->wantsJson()) {
            return response()->json(['data' => $dados]);
        }

        $estados = $this->estadoRepository->buscarTodosOrdenados('uf');

        return view('municipio.index', compact('dados', 'filtros', 'estados'));
    }

    /**
     * Exibe a tela para adicionar um novo registro.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adicionar()
    {
        $estados = $this->estadoRepository->buscarTodosOrdenados('uf');

        return view('municipio.adicionar', compact('estados'));
    }

    /**
     * Adiciona um novo registro.
     *
     * @param \Modules\Nucleo\Http\Requests\SalvarMunicipioRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(SalvarMunicipioRequest $request)
    {
        $registro = $this->repository->create($request->all());
        if (!$registro->id) {
            return back()->withInput();
        }

        flash('Registro salvo com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'municipio', $registro);
    }

    /**
     * Exibe a tela para alterar os dados de um registro.
     *
     * @param Municipio $municipio
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alterar(Municipio $municipio)
    {
        $estados = $this->estadoRepository->buscarTodosOrdenados('uf');

        return view('municipio.alterar', compact('municipio', 'estados'));
    }

    /**
     * Altera os dados de um registro.
     *
     * @param Municipio $registro
     * @param \Modules\Nucleo\Http\Requests\SalvarMunicipioRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function atualizar(Municipio $registro, SalvarMunicipioRequest $request)
    {
        $atualizado = $this->repository->update($registro, $request->all());
        if (!$atualizado) {
            return back()->withInput();
        }

        flash('Os dados do registro foram alterados com sucesso.')->success();

        return $this->tratarRedirecionamentoCrud(request('acao'), 'municipio', $registro);
    }

    /**
     * Exclui um registro.
     *
     * @param Municipio $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function excluir(Municipio $registro)
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
