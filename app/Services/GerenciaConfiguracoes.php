<?php

namespace App\Services;

use Exception;
use App\Models\Configuracao;
use App\Repositories\ConfiguracaoRepository;

class GerenciaConfiguracoes
{

    /**
     * @var ConfiguracaoRepository
     */
    private $configuracaoRepository;

    public function __construct(ConfiguracaoRepository $configuracaoRepository)
    {
        $this->configuracaoRepository = $configuracaoRepository;
    }

    /**
     * Salva as configurações do sistema.
     *
     * @param array $dados
     *
     * @return Configuracao
     * @throws Exception
     */
    public function salvar(array $dados): Configuracao
    {
        $configuracoes = $this->buscarConfiguracoes();
        $this->configuracaoRepository->update($configuracoes, $dados);
        $this->limparCache();

        return $this->buscarConfiguracoes();
    }

    /**
     * Retorna as configurações do sistema.
     *
     * @return Configuracao
     * @throws Exception
     */
    public function buscarConfiguracoes()
    {
        $configuracoes = cache()->rememberForever('configuracoes_sistema', function () {
            return $this->configuracaoRepository->buscarConfiguracoes();
        });

        return $configuracoes;
    }

    /**
     * Limpa do cache as configurações.
     */
    public function limparCache()
    {
        cache()->forget('configuracoes_sistema');
    }

    /**
     * Retorna os fusos disponíveis.
     *
     * @return array
     */
    public function carregarFusos()
    {
        return collect(
            [
                'America/Noronha',
                'America/Belem',
                'America/Fortaleza',
                'America/Recife',
                'America/Araguaina',
                'America/Maceio',
                'America/Bahia',
                'America/Sao_Paulo',
                'America/Campo_Grande',
                'America/Cuiaba',
                'America/Santarem',
                'America/Porto_Velho',
                'America/Boa_Vista',
                'America/Manaus',
                'America/Eirunepe',
                'America/Rio_Branco',
            ]
        )->sort();
    }

}
