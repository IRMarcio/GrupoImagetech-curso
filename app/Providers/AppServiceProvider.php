<?php

namespace App\Providers;

use App\Routing\UrlGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        Carbon::setLocale('pt_BR');
        Schema::defaultStringLength(191);

        // Instancia uma versão personalizada do URLGenerator para este sistema
        $routes = $this->app['router']->getRoutes();
        $customUrlGenerator = new UrlGenerator($routes, $this->app->make('request'));
        $this->app->instance('url', $customUrlGenerator);
    }
}
