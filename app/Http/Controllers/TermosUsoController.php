<?php

namespace App\Http\Controllers;

use DB;
use App\Services\GerenciaConfiguracoes;
use App\Services\Usuario\GerenciaUsuario;

class TermosUsoController extends Controller
{

    /**
     * @var GerenciaConfiguracoes
     */
    private $gerenciaConfiguracoes;

    /**
     * @var GerenciaUsuario
     */
    private $gerenciaUsuario;

    public function __construct(
        GerenciaConfiguracoes $gerenciaConfiguracoes,
        GerenciaUsuario $gerenciaUsuario
    ) {
        parent::__construct();

        $this->gerenciaConfiguracoes = $gerenciaConfiguracoes;
        $this->gerenciaUsuario = $gerenciaUsuario;
    }

    /**
     * Exibe tela de aceite dos termos de uso
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function aceite()
    {
        dd('termos de uso aceite');
        $configuracoes = $this->gerenciaConfiguracoes->buscarConfiguracoes();
        $termosUso = $configuracoes->termos_uso;

        return view('termo_uso.aceite', compact('termosUso'));
    }

    /**
     * Registra aceita dos termos de uso
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registrarAceite()
    {
        // Registra o aceite
        DB::transaction(function () {
            $this->gerenciaUsuario->registrarAceiteTermosUso(auth()->user()->id);
        });

        return redirect()->route('dashboard');
    }
}
