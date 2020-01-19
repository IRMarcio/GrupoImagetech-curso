<?php

namespace App\Http\Middleware;

use App\Services\Auditor;
use Closure;
use Route;

class Auditoria
{

    /**
     * @var Auditor
     */
    private $auditor;

    public function __construct(Auditor $auditor)
    {
        $this->auditor = $auditor;
    }

    /**
     * Trata o request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        // Se estiver rodando via console ou usuário não estiver logado
        if (app()->runningInConsole() || !auth()->check()) {
            return $next($request);
        }

        // Limpa o auditoria_id da sessão
        session()->forget('auditoria_id');

        // Se requisição for GET e não AJAX, loga na auditoria
        if (request()->method() === 'GET' && !request()->wantsJson()) {
            $this->auditor->auditar(Route::current()->getName(), auth()->user()->id);
        }

        return $next($request);
    }
}
