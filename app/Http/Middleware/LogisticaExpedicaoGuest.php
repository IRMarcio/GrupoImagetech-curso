<?php

namespace App\Http\Middleware;

use App\Services\CentroDistribuicaoUnidade;
use App\Services\SessaoUsuario;
use App\Traits\DashboardAgenteTrait;
use Closure;
use View;

class LogisticaExpedicaoGuest
{
    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(SessaoUsuario $sessaoUsuario)
    {
        $this->sessaoUsuario = $sessaoUsuario;
    }

    use DashboardAgenteTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $centroDistribuicao = null;
        $dadosGeral = [];

        //Busca usuario logado;
        $usuarioLogado = auth()->user();

        if (
            auth()->check() &&
            !app()->runningInConsole() &&
            !request()->wantsJson()
        ) {
            if ($this->sessaoUsuario->centroDistribuicao())
                $centroDistribuicao = $this->sessaoUsuario->centroDistribuicao()->id;
        }
        if ($this->guestDadosLogisticaExpedicao($centroDistribuicao))
            $dadosGeral = $this->guestDadosLogisticaExpedicao($centroDistribuicao);

        // Compartilha com todas as views a logistica/expedicao
        View::share('logisticaExpedicao', $dadosGeral);

        return $next($request);
    }
}
