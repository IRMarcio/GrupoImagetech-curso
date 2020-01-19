<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\SessaoUsuario;
use View;

class DescobrirUnidadeAtiva
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
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Se estivermos na própria rota de selecionar unidade, vamos ignorar e continuar a requisição
        $routeName = $request->route()->getName();
        if (strpos($routeName, "selecionar_unidade") !== false) {
            return $next($request);
        }

        // Procura pela unidade ativa, se não tiver nenhuma setada, vamos redirecionar o usuário para que ele selecione
        // Mas antes verificamos se usuário é super-admin e não tiver nenhuma unidade, deixamos passar
        $unidade = $this->sessaoUsuario->unidade();


        // Usuário logado
        $usuarioLogado = auth()->user();

        // Se não tiver selecionado unidade, só deixa passar se usuário logado for super_admin
        if (is_null($unidade) && $usuarioLogado->unidades()->count()) {
            return redirect()->route('selecionar_unidade');
        }

        // Compartilha com todas as views a unidade ativa
        View::share('unidadeAtiva', $unidade);

        return $next($request);
    }
}
