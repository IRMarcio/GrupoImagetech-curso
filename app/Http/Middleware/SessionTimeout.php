<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\GerenciaConfiguracoes;
use App\Services\GerenciaSession;
use Route;

class SessionTimeout
{

    /**
     * @var GerenciaConfiguracoes
     */
    private $gerenciaConfiguracoes;
    
    /**
     * @var GerenciaSession
     */
    private $gerenciaSession;

    public function __construct(
        GerenciaConfiguracoes $gerenciaConfiguracoes,
        GerenciaSession $gerenciaSession
    ) {
        $this->gerenciaConfiguracoes = $gerenciaConfiguracoes;
        $this->gerenciaSession = $gerenciaSession;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {

//         Busca as configurações para pegar o tempo máximo da sessão
        $configuracoes = $this->gerenciaConfiguracoes->buscarConfiguracoes();
        $tempoMaximoSessao = $configuracoes->tempo_maximo_sessao;

        if (
            !$this->gerenciaSession->sessaoUsuarioEhValida(auth()->user()->id, $tempoMaximoSessao) ||
            $this->gerenciaSession->sessaoUsuarioEstaBloqueada(auth()->user()->id)
        ) {
            return $this->sessaoExpirada();
        }

        return $next($request);
    }

    /**
     * Executa a rotina de uma sessão expirada
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    private function sessaoExpirada()
    {
        // Força logout
        $this->gerenciaSession->forcarLogoutPorInatividade(auth()->user()->id);

        // Msg avisando que sessão expirou
        flash('Sessão expirada.')->error();

        // Redireciona
        return redirect('login');
    }
}
