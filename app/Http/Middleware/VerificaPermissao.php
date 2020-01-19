<?php

namespace App\Http\Middleware;

use App\Services\SessaoUsuario;
use Closure;
use Gate;

class VerificaPermissao
{

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(SessaoUsuario $sessaoUsuario)
    {
        $this->sessaoUsuario = $sessaoUsuario;
    }

    /**
     * Trata o request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $routeName = $request->route()->getName();

        if (strpos($routeName, '.post') == false && $request->method() == 'GET' && $routeName !== 'nao_autorizado') {
            if (Gate::denies($routeName)) {
                return response()->make(view('sem-permissao'), 401);
            }
        }

        return $next($request);
    }
}
