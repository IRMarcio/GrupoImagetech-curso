<?php

namespace App\Services;

use App\Models\Rota;
use App\Repositories\AuditoriaAcaoRepository;
use App\Repositories\AuditoriaRepository;
use Exception;
use Illuminate\Support\Collection;
use Route;

/**
 * Essa é a classe responsável por adicionar na auditoria tudo que acontece no sistema: novos registros, registros
 * alterados e/ou exclusões.
 *
 * @package App\Services
 */
class Auditor
{
    /**
     * @var AuditoriaRepository
     */
    private $auditoriaRepository;

    /**
     * @var AuditoriaAcaoRepository
     */
    private $auditoriaAcaoRepository;

    public function __construct(
        AuditoriaRepository $auditoriaRepository,
        AuditoriaAcaoRepository $auditoriaAcaoRepository
    ) {
        $this->auditoriaRepository = $auditoriaRepository;
        $this->auditoriaAcaoRepository = $auditoriaAcaoRepository;
    }

    /**
     * Cria uma ação de auditoria. Um registro de auditoria pode ter várias ações.
     *
     * @param \Illuminate\Database\Eloquent\Model $evento Model eloquent que está sendo alterado
     * @param array $alterado Conteúdo que foi alterado
     * @param array $original Conteúdo original
     * @param array $acao A ação realizada no conteudo. (insert(I), delete(D) ou update(U))
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public function adicionaAlteracoes($evento, $alterado, $original = [], $acao)
    {
        $dados['tabela'] = $evento->getTable();
        $dados['registro_id'] = $evento->getKey();
        $dados['acao_tabela'] = $acao;
        $dados['dados_new'] = $alterado;
        $dados['dados_old'] = $original;
        $dados['dados_alt'] = array_diff($alterado, $original);

        // Procuramos na sessão se um registro de auditoria já foi criado
        // caso não tenha sido criado ainda, criamos um novo e a partir de
        // agora tudo que é alteração vai parar no mesmo registro de auditoria
        $idAuditoria = session('auditoria_id');
        if (is_null($idAuditoria)) {
            $auditoria = $this->auditar();
            $idAuditoria = $auditoria->id;
        }
        $dados['auditoria_id'] = $idAuditoria;

        return $this->auditoriaAcaoRepository->create($dados);
    }

    /**
     * Grava na tabela de auditoria um registro representando uma ação no sistema.
     *
     * @param null|string $rota O nome da rota.
     * @param null|int $usuarioId ID do usuário.
     * @param null|string $descricao Descrição personalizada que irá na auditoria.
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws Exception
     */
    public function auditar($rota = null, $usuarioId = null, $descricao = null)
    {
        $dados = [];
        $dados['endereco_ipv4'] = enderecoIp();

        // Capturando o método da requisição, se for via console vai setar CONSOLE
        $dados['metodo'] = app()->runningInConsole() === true ? 'CONSOLE' : request()->method();
        
        // Se o request for JSON pegamos
        if (!is_null($_POST) && count($_POST) == 0) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        $dados['dados_post'] = json_encode(app()->runningInConsole() === false ? $this->dadosPost() : null);
        if (is_null($dados['dados_post'])) {
            $dados['dados_post'] = [];
        }

        $dados['dados_get'] = json_encode(app()->runningInConsole() === false ? $_GET : []);
        $dados['dados_server'] = json_encode($this->dadosServer());
        $dados['usuario_id'] = $usuarioId ? $usuarioId : auth()->user()->id;
        $dados['descricao'] = $descricao;

        if ($rota == null) {
            // Se estiver rodando no console, vamos dizer que a rota é uma rota diferente, pois não há rotas quando roda pelo console
            if (app()->runningInConsole()) {
                $rota = 'terminal';
            } else {
                $rota = Route::current()->getName();
            }

            if (strstr($rota, '.post')) {
                $rota = str_replace('.post', '', $rota);
            }
        }

        $metodo = $this->buscarRota($rota);

        if (is_null($metodo)) {
            throw new Exception("Rota {$rota} não encontrada para auditoria. Você já criou esta rota no banco?");
        }

        $dados['rota_id'] = $metodo->id;
        $dados['tipo_rota_id'] = $metodo->tipo_rota_id;

        $registro = $this->auditoriaRepository->create($dados);

        // Seta na sessão o ID desta auditoria para que ele seja aproveitado por outras alterações
        session(['auditoria_id' => $registro->id]);

        return $registro;
    }

    /**
     * Remove dados sensíveis da variavel global $_POST.
     *
     * @return mixed
     */
    private function dadosPost()
    {
        $dadosPost = $_POST;

        if (empty($dadosPost)) {
            return [];
        }

        $remover = ['password', 'senha', 'nova_senha', '_token', 'nova_senha_confirmation', 'password_confirmation'];
        foreach ($dadosPost as $chave => $conteudo) {
            if (in_array($chave, $remover)) {
                unset($dadosPost[$chave]);
            }
        }

        return $dadosPost;
    }

    /**
     * Remove dados sensíveis da variavel global $_SERVER.
     *
     * @return mixed
     */
    private function dadosServer()
    {
        $server = request()->server();
        $manter = ['HTTP_USER_AGENT', 'HTTP_REFERER', 'REMOTE_ADDR', 'REQUEST_SCHEME', 'REQUEST_METHOD', 'QUERY_STRING', 'REQUEST_URI', 'REQUEST_TIME'];
        foreach ($server as $chave => $conteudo) {
            if (!in_array($chave, $manter)) {
                unset($server[$chave]);
            }
        }

        return $server;
    }

    /**
     * Busca os dados da rota que será auditada.
     *
     * @param string $rota
     *
     * @return Collection
     */
    private function buscarRota($rota)
    {
        $rotasEspeciais = [
            'password.reset',
            'login',
            'login_erro',
            'login_bloqueado',
            'logout',
            'bloquear_tela',
            'tela_bloqueada',
            'tela_desbloqueada',
            'tela_bloqueada_inatividade',
            'desbloqueio_tela_erro',
            'logout_sessao_expirada',
            'termos_uso.aceite',
            'tentativas_login',
            'arquivo.upload',
            'arquivo.visualizar',
        ];

        if (in_array($rota, $rotasEspeciais)) {
            return Rota::where('rota', $rota)->first();
        }

        return Rota::all()->filter(function ($registro) use ($rota) {
            return $registro->rota == $rota;
        })->first();
    }

    /**
     * Adiciona uma entrada na auditoria de forma manual.
     *
     * @param string $tabela O nome da tabela que o evento se relaciona
     * @param int $id ID do conteúdo sendo alterado
     * @param string $acao I, D, U
     * @param string $rota O nome da rota relacionada ao evento
     * @param int $usuarioId Id do usuário que fez a ação.
     * @param null|string $descricao Descrição da ação realizada (opcional).
     *
     * @return void
     * @throws Exception
     */
    public function adicionarAlteracaoSimples($tabela, $id, $rota, $usuarioId, $acao, $descricao = null)
    {
        $idAuditoria = session('auditoria_id');
        if (is_null($idAuditoria)) {
            $auditoria = $this->auditar($rota, $usuarioId, $descricao);
            $idAuditoria = $auditoria->id;
        }

        if (is_null($tabela)) {
            return;
        }

        $dados['tabela'] = $tabela;
        $dados['registro_id'] = $id;
        $dados['acao_tabela'] = $acao;
        $dados['dados_new'] = [];
        $dados['dados_old'] = [];
        $dados['dados_alt'] = [];
        $dados['auditoria_id'] = $idAuditoria;

        $this->auditoriaAcaoRepository->create($dados);
    }

}
