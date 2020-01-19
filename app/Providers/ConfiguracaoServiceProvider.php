<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GerenciaConfiguracoes;
use Schema;

class ConfiguracoesServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \Exception
     */
    public function boot()
    {
        // Só queremos configurar quando estivermos dentro do sistema e se a tabela já foi criada
        if (!app()->runningUnitTests()) {
            if (Schema::hasTable('configuracao')) {
                $gerenciaConfiguracoes = app(GerenciaConfiguracoes::class);
                $configuracoes = $gerenciaConfiguracoes->buscarConfiguracoes();

                if ($configuracoes) {

                    // Configura o timezone da aplicação
                    config(['app.timezone' => $configuracoes->timezone]);

                    // Configura a ação que será realizada após timeout da sessão
                    config(['session.acao_apos_timeout' => $configuracoes->acao_apos_timeout_sessao]);
                }
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

}
