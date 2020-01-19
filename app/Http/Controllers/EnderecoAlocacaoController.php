<?php

namespace App\Http\Controllers;

use App\Services\GerenciaCentroDistribuicao;
use App\Services\SessaoUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnderecoAlocacaoController extends Controller
{
    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;
    /**
     * @var GerenciaCentroDistribuicao
     */
    private $gerencia;

    public function __construct(SessaoUsuario $sessaoUsuario, GerenciaCentroDistribuicao $gerencia)
    {
        parent::__construct();

        $this->sessaoUsuario = $sessaoUsuario;
        $this->gerencia = $gerencia;
    }

    /**
     *
     * */
    public function adicionar($area = null, $rua = null)
    {
        $centro = $this->sessaoUsuario->centroDistribuicao();
        $enderecos = $centro->endAlocacao;
        return view('centro_distribuicao.endereco.adicionar_endereco', compact('enderecos'));
    }

    /**
     *
     * */
    public function salvar()
    {
        $url = request()->url;
        $cadastro = DB::transaction(function () {
            $this->gerencia->createEnderecoAlocacao();
        });

        if (!$cadastro) {
            flash('Falha no cadastro. Favor entrar em contato com o suporte técnico.')->error();
            return back()->withInput();
        }
        flash('Os dados do registro foram cadastrados com sucesso.')->success();

        return redirect($url);
    }
}
