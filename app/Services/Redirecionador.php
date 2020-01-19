<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Password;
use App\Models\Usuario;

class Redirecionador
{

    /**
     * @var ChecagemSenhaPadrao
     */
    private $checagemSenhaPadrao;

    /**
     * @var GerenciaConfiguracoes
     */
    private $gerenciaConfiguracoes;

    public function __construct(
        ChecagemSenhaPadrao $checagemSenhaPadrao,
        GerenciaConfiguracoes $gerenciaConfiguracoes
    ) {
        $this->checagemSenhaPadrao = $checagemSenhaPadrao;
        $this->gerenciaConfiguracoes = $gerenciaConfiguracoes;
    }

    /**
     * Descobre o local certo para redirecionamento do usuário quando ele realizar login.
     *
     * @param Usuario $user Os dados do usuário que fez login.
     * @param string $senha
     *
     * @return string
     * @throws Exception
     */
    public function descobrirRedirecionamento(Usuario $user, $senha)
    {
        $url = $this->verificaSenhaPadrao($user, $senha);
        if (!is_null($url)) {
            return $url;
        }

        $url = $this->verificaNecessidadeResetarSenha($user);
        if (!is_null($url)) {
            return $url;
        }

        $url = $this->verificaSenhaInvalidada($user);
        if (!is_null($url)) {
            return $url;
        }

        // Primeiro vamos pegar todos os perfis do usuário que correspondem ao tipo de login escolhido
        $perfis = $user->perfis;
        $usuarioLogado = auth()->user();
        if (count($perfis) == 0 && $usuarioLogado->super_admin === false) {
            $mensagem = 'Usuário não tem permissão para realizar login.';
            flash($mensagem)->error();
            throw new Exception($mensagem, 401);
        }   

        // Redireciona para o dashboard
        return route("dashboard");
    }

    /**
     * Realiza a checagem para saber se o usuário está com a senha padrão.
     *
     * @param Usuario $user
     * @param string $senha
     *
     * @return null|string
     */
    private function verificaSenhaPadrao($user, $senha)
    {
        $necessitaAlterarSenha = $this->checagemSenhaPadrao->necessitaAlterar($user, $senha);
        if ($necessitaAlterarSenha) {
            flash("Verificamos que você está usando a senha padrão. Por favor, por questões de segurança altere a sua senha no formulário abaixo.");
            $url = $this->criarLinkResetSenha($user);

            return $url;
        }

        return null;
    }

    /**
     * Cria a URL para resetar a senha do usuário.
     *
     * @param Usuario $user
     *
     * @return string
     */
    private function criarLinkResetSenha($user)
    {
        // TODO: remover facade e injetar classe
        $token = Password::getRepository()->create($user);
        $url = route('password.reset', $token);
        session()->forget('url.intended');
        auth()->logout();

        return $url;
    }

    /**
     * Pega a data da ultima alteração de senha do usuário e compara com o tempo máximo para troca de senhas.
     * Caso tenha passado, desloga o usuário e o redireciona para a tela de troca de senha.
     *
     * @param Usuario $user
     *
     * @return null|string
     * @throws Exception
     */
    private function verificaNecessidadeResetarSenha($user)
    {
        $dataUltimaAlteracao = $user->ultima_alteracao_senha;
        if (is_null($dataUltimaAlteracao)) {
            return null;
        }

        $configuracoes = $this->gerenciaConfiguracoes->buscarConfiguracoes();
        $maxDias = $configuracoes->dias_max_alterar_senha;
        $agora = now(config('app.timezone'));
        $diasPassados = $agora->diffInDays($dataUltimaAlteracao);

        if ($diasPassados >= $maxDias) {
            flash("Notamos que fazem $diasPassados dias que você alterou sua senha. Por favor, por questões de segurança você foi redirecionado para esta página para gerar uma nova senha.")->info();

            return $this->criarLinkResetSenha($user);
        }

        return null;
    }

    /**
     * Verifica se a senha do usuário que está tentando logar foi invalidada por algum administrador.
     * Caso sim, ele será obrigado a gerar outra.
     *
     * @param Usuario $user
     *
     * @return bool
     */
    private function verificaSenhaInvalidada($user)
    {
        if ($user->temSituacao('senha_invalidada')) {
            flash("Foi requisitado por um administrador a geração de uma nova senha para o seu usuário. Preencha o formulário abaixo para gerar uma nova senha.")->info();

            return $this->criarLinkResetSenha($user);
        }

        return null;
    }
}
