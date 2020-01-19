<?php

namespace App\Providers;

use App\Http\ViewComposers\BarraTopoComposer;
use App\Http\ViewComposers\CentroDistribuicaoComposer;
use App\Http\ViewComposers\MenuComposer;
use Illuminate\Support\ServiceProvider;



class ViewComposerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('partials.menu.menu_principal', MenuComposer::class);
        view()->composer('partials.barra_topo', BarraTopoComposer::class);
        view()->composer(['centro_distribuicao.adicionar', 'centro_distribuicao.alterar'], CentroDistribuicaoComposer::class);
    }
}
