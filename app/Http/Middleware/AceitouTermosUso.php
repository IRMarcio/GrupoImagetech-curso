<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\GerenciaConfiguracoes;
use View;

class AceitouTermosUso
{

    /**
     * @var GerenciaConfiguracoes
     */
    private $gerenciaConfiguracoes;

    public function __construct(GerenciaConfiguracoes $gerenciaConfiguracoes)
    {
        $this->gerenciaConfiguracoes = $gerenciaConfiguracoes;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $usuario = auth()->user();

        // Se usuário for super admin ou
        // Se usuário já tiver aceito os termos de uso ou
        if ($usuario->super_admin || $usuario->aceitou_termos_uso) {
            return $next($request);
        }

        // Se os termos de uso estivem vazio
        // Busca as configurações para pegar os termos de uso
        $configuracoes = $this->gerenciaConfiguracoes->buscarConfiguracoes();
        if (empty($configuracoes->termos_uso)) {
            return $next($request);
        }


        // Redireciona para página dos termos de uso
        return redirect()->route('termos_uso.aceite');
    }
}
