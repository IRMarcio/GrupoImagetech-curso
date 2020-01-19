<?php

namespace App\Services;

use Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Repositories\UsuarioHistoricoSenhaRepository;

/**
 * Valida se a senha que o usuário entrou no formulário de alterar/resetar senha é permitida pelo sistema.
 */
class ValidaSenhaAlterada
{

    /**
     * @var UsuarioHistoricoSenhaRepository
     */
    private $historicoSenhaRepo;

    public function __construct(UsuarioHistoricoSenhaRepository $historicoSenhaRepo)
    {
        $this->historicoSenhaRepo = $historicoSenhaRepo;
    }

    /**
     * Realiza a validação da senha.
     *
     * @param Authenticatable $usuario
     * @param string $senha Nova senha digitada pelo usuário
     *
     * @return bool
     */
    public function validar(Authenticatable $usuario, $senha)
    {
        return $this->validarTamanho($senha) &&
            $this->validarSomenteNumeros($senha) &&
            $this->validarSomenteLetras($senha) &&
            $this->validarDocumentos($senha, $usuario) &&
            $this->compararHistoricoSenhas($senha, $usuario);
    }

    /**
     * Valida se a senha tem pelo menos x caracteres.
     *
     * @param string $senha Nova senha digitada pelo usuário
     *
     * @return bool
     */
    private function validarTamanho($senha)
    {
        return strlen($senha) >= 8;
    }

    /**
     * Verifica se a senha contém somente números.
     *
     * true -> senha está valida, contém outros caracteres.
     * false -> senha contém somente numeros.
     *
     * @param string $senha Nova senha digitada pelo usuário
     *
     * @return bool
     */
    private function validarSomenteNumeros($senha)
    {
        return !ctype_digit($senha);
    }

    /**
     * Verifica se a senha contém somente letras.
     *
     * true -> senha está valida, contém letras e outros caracteres.
     * false -> senha contém somente letras.
     *
     * @param string $senha Nova senha digitada pelo usuário
     *
     * @return bool
     */
    private function validarSomenteLetras($senha)
    {
        return !ctype_alpha($senha);
    }

    /**
     * Valida se a senha é algum dos documentos do usuário.
     *
     * true -> senha não é nenhum dos documentos do usuário.
     * false -> senha é igual a algum dos documentos do usuário.
     *
     * @param string $senha Nova senha digitada pelo usuário
     * @param Authenticatable $usuario
     *
     * @return bool
     */
    private function validarDocumentos($senha, $usuario)
    {
        $senha = Mascarado::removerMascara($senha);

        $cpf = Mascarado::removerMascara($usuario->cpf);

        return $cpf != $senha;
    }

    /**
     * Valida se a nova senha é diferente da antiga.
     *
     * true -> senha válida, é diferente da última senha do usuário.
     * false -> a senha nova é a mesma da última senha do usuário.
     *
     * @param string $senha Nova senha digitada pelo usuário
     * @param Authenticatable $usuario
     *
     * @return bool
     */
    private function compararHistoricoSenhas($senha, $usuario)
    {
        $atualHashed = $usuario->getAuthPassword();
        $historicoSenhas = $this->historicoSenhaRepo->buscarTodasSenhas($usuario->id);

        $contem = $historicoSenhas->filter(function ($senhaHistorico) use ($senha) {
            return Hash::check($senha, $senhaHistorico->senha);
        });

        return count($contem) == 0 && Hash::check($senha, $atualHashed) == false;
    }

}
