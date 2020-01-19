<?php

namespace App\Repositories;

use App\Models\Configuracao;

class ConfiguracaoRepository extends CrudRepository
{

    protected $modelClass = Configuracao::class;

    /**
     * Retorna as configurações do sistema.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object
     */
    public function buscarConfiguracoes()
    {
        $config = $this->newQuery()->first();
        if (is_null($config)) {
            // Caso não exista config, criamos uma nova com alguns padrões
            $config = $this->create(
                [
                    'email_nome'                => 'SIGA TECNOLOGIAS DO BRASIL',
                    'timezone'                  => 'America/Campo_Grande',
                    'tempo_maximo_sessao'       => 120,
                    'acao_apos_timeout_sessao'  => 'B',
                    'max_tentativas_login'      => 5,
                    'dias_max_alterar_senha'    => 182
                ]
            );
        }

        return $config;
    }
}
