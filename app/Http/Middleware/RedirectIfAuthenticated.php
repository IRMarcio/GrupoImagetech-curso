<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Route;

class RedirectIfAuthenticated
{
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
        // Se rota for login.post não faz a checagem
        if (Auth::guard($guard)->check() && Route::currentRouteName() !== 'login.post') {
            return redirect()->intended(route('dashboard'));
        }

        return $next($request);
    }
}
