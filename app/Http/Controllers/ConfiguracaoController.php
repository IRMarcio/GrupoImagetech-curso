<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalvarConfiguracaoRequest;
use App\Models\Configuracao;
use App\Services\GerenciaConfiguracoes;
use Swift_Mailer;
use Swift_SmtpTransport;
use App\Services\TratarSessoesInvalidas;

class ConfiguracaoController extends Controller
{

    /**
     * @var GerenciaConfiguracoes
     */
    private $gerenciaConfiguracoes;

    public function __construct(
        GerenciaConfiguracoes $gerenciaConfiguracoes,
        TratarSessoesInvalidas $tratarSessoesInvalidas)
    {
        parent::__construct();

        $this->gerenciaConfiguracoes = $gerenciaConfiguracoes;
        $this->tratarSessoesInvalidas = $tratarSessoesInvalidas;
    }

    /**
     * Exibe a tela de configurações do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        $this->tratarSessoesInvalidas->tratar();
        $config = $this->gerenciaConfiguracoes->buscarConfiguracoes();

        $fusos = $this->gerenciaConfiguracoes->carregarFusos();
        $acoesAposTimeoutSessao = Configuracao::$acoesAposTimeoutSessao;

        return view('configuracoes.index', compact('config', 'fusos', 'acoesAposTimeoutSessao'));
    }

    /**
     * Rotina para atualizar as configurações do sistema.
     *
     * @param SalvarConfiguracaoRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function salvar(SalvarConfiguracaoRequest $request)
    {
        $dados = $request->all();
        $this->gerenciaConfiguracoes->salvar($dados);

        flash('As configurações do sistema foram atualizadas com sucesso.')->success();

        return back();
    }

    /**
     * Testa a configuração de e-mail informada.
     *
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function testarEmail()
    {
        $dados = request()->all();

        try {
            $transport = new Swift_SmtpTransport($dados['email_host'], $dados['email_porta'], $dados['email_encriptacao']);
            $transport->setUsername($dados['email']);
            $transport->setPassword($dados['email_senha']);
            $mailer = new Swift_Mailer($transport);
            $mailer->getTransport()->start();

            return response()->json('Conexão estabelecida com sucesso!');
        }
        catch (Exception $e) {
            Log::error("Falha na conexão com email: " . $e);

            return response()->json('Falha na conexão: <br><br>' . $e->getMessage());
        }
    }
}
