<?php

namespace App\Http\Middleware;

use App\Services\PerfilPrincipal;
use App\Services\SessaoUsuario;
use Closure;

class DescobrirPerfilPrincipal
{

    /**
     * @var PerfilPrincipal
     */
    private $perfilPrincipal;

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(
        PerfilPrincipal $perfilPrincipal,
        SessaoUsuario $sessaoUsuario
    ) {
        $this->perfilPrincipal = $perfilPrincipal;
        $this->sessaoUsuario = $sessaoUsuario;
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
        if (
            auth()->check() &&
            !app()->runningInConsole() &&
            !request()->wantsJson()
        ) {

            // Queremos setar a função ativa se a mesma for nula ou ainda não foi setada
            $perfilAtivo = $this->sessaoUsuario->dados('perfil_ativo');

            if (is_null($perfilAtivo)) {
                $perfilAtivo = $this->perfilPrincipal->descobrirPerfilPrincipal();
                $this->sessaoUsuario->atualizarDados('perfil_ativo', $perfilAtivo);
            }
        }
        return $next($request);
    }
}
