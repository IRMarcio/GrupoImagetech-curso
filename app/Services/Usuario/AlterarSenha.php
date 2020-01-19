<?php

namespace App\Services\Usuario;

use App\Services\ValidaSenhaAlterada;
use Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Repositories\UsuarioHistoricoSenhaRepository;
use App\Services\GerenciaConfiguracoes;

class AlterarSenha
{

    /**
     * @var ValidaSenhaAlterada
     */
    private $validaSenhaAlterada;

    /**
     * @var GerenciaConfiguracoes
     */
    private $gerenciaConfiguracoes;

    /**
     * @var UsuarioHistoricoSenhaRepository
     */
    private $senhaHistoricoRepo;

    public function __construct(
        ValidaSenhaAlterada $validaSenhaAlterada,
        GerenciaConfiguracoes $gerenciaConfiguracoes,
        UsuarioHistoricoSenhaRepository $senhaHistoricoRepo
    ) {
        $this->validaSenhaAlterada = $validaSenhaAlterada;
        $this->gerenciaConfiguracoes = $gerenciaConfiguracoes;
        $this->senhaHistoricoRepo = $senhaHistoricoRepo;
    }

    /**
     * Executa todas as validações para validar a senha do usuário sendo alterada.
     *
     * @param Authenticatable $usuario
     * @param array $dados
     *
     * @return bool
     */
    public function validar($usuario, $dados)
    {
        if ($this->validaSenhaAlterada->validar($usuario, $dados['nova_senha']) === false) {
            flash('A nova senha informada não está de acordo com os padrões de segurança do sistema. Tente outra senha mais segura.')->error();

            return false;
        }

        if (!Hash::check($dados['senha'], $usuario->getAuthPassword())) {
            flash('A senha atual digitada está incorreta.')->error();

            return false;
        }

        return true;
    }

    /**
     * Altera de fato a senha do usuário.
     *
     * @param Authenticatable $usuario
     * @param string $novaSenha
     *
     * @throws \Exception
     */
    public function alterar(Authenticatable $usuario, $novaSenha)
    {
        $configuracoes = $this->gerenciaConfiguracoes->buscarConfiguracoes();

        $senhasHistorico = $this->senhaHistoricoRepo->buscarTodasSenhas($usuario->id);
        $totalSenhasHistorico = count($senhasHistorico);

        // Enquanto o total de senhas salvas no histórico deste usuário for maior que o máximo a ser guardado
        // vamos excluindo sempre a mais antiga
        while ($totalSenhasHistorico >= $configuracoes->max_senhas_historico) {
            $aRemover = $senhasHistorico->last();
            $aRemover->delete();

            $senhasHistorico = $senhasHistorico->filter(function ($item) use ($aRemover) {
                return $item->id != $aRemover->id;
            });
            $totalSenhasHistorico = count($senhasHistorico);
        }

        // Salva no histórico a senha atual
        $this->senhaHistoricoRepo->create(['usuario_id' => $usuario->id, 'senha' => $usuario->senha]);

        // E por final altera a senha do usuário para a nova
        $usuario->update(
            [
                'ultima_alteracao_senha' => now(config('app.timezone')),
                'senha'                  => $novaSenha
            ]
        );

        // Caso a senha deste usuário tenha sido invalidada, agora ela não é mais, pois o usuário já alterou a senha
        if ($usuario->temSituacao('senha_invalidada')) {
            $usuario->removerSituacao('senha_invalidada');
        }

        // Caso o usuário tenha sido bloqueado por tentativas erradas de login, removemos também
        if ($usuario->temSituacao('bloqueado_tentativa')) {
            $usuario->removerSituacao('bloqueado_tentativa');

            // Queremos logar também que o usuário foi desbloqueado
            auditar('usuario', $usuario->id, 'usuario.desbloquear_tentativas', $usuario->id, 'U');
        }
    }
}
