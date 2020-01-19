<?php

namespace App\Http\Middleware;

use App\Services\ChecaPermissao;
use App\Services\SessaoUsuario;
use Closure;
use Gate;
use Illuminate\Support\Collection;

class DefinirPermissoes
{

    /**
     * @var ChecaPermissao
     */
    private $checaPermissao;

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(
        ChecaPermissao $checaPermissao,
        SessaoUsuario $sessaoUsuario
    ) {
        $this->checaPermissao = $checaPermissao;
        $this->sessaoUsuario = $sessaoUsuario;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!auth()->check()) {
            return $next($request);
        }

        if (!app()->runningInConsole()) {
            $rotas = $this->buscarRotas();
            foreach ($rotas as $rota) {
                Gate::define($rota->rota, function ($usuario) use ($rota) {
                    // Se ela for acesso liberado, liberado logo
                    if ($rota->acesso_liberado == 'S') {
                        return true;
                    }

                    // Se algum dos grupos de acesso do usuário contem um grupo que é super admin
                    // liberamos a rota para ele sem perguntar mais nada
                    $superAdmin = $usuario->super_admin;
                    if ($superAdmin) {
                        return true;
                    }

                    // Caso contrário, iremos verificar se em algum grupo a rota está definida como permitida
                    // Se tiver pelo menos um grupo dizendo que é permitida, este ganha.
                    return $this->checaPermissao->temAcesso($rota);
                });
            }
        }

        return $next($request);
    }

    /**
     * Retorna todas as rotas do módulo ativo.
     *
     * @return Collection
     */
    public function buscarRotas()
    {
        $rotas = $this->sessaoUsuario->dados('rotas');
        if (is_null($rotas)) {
            $rotas = $this->sessaoUsuario->setarRotas();
        }

        return $rotas;
    }
}
