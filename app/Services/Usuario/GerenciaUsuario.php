<?php

namespace App\Services\Usuario;

use App\Services\Mascarado;
use App\Models\Perfil;
use App\Models\Usuario;
use App\Models\Unidade;

class GerenciaUsuario
{
    /**
     * Carrega as dependências para cadastro/alteração de usuário
     *
     * @param null $registro
     *
     * @return array
     */
    public function dependencias(Usuario $usuarioLogado, $registro = null)
    {
        // Se usuário for gestor vai dar possibilidade de selecionar qualquer unidade
        // Caso contrário usuário poderá selecionar somente unidades das quais faz parte
        if ( $usuarioLogado->super_admin) {
            $unidades = Unidade::where('ativo', true)->orderBy('descricao', 'ASC')->get();
        } else {
            $unidades = $usuarioLogado->unidades();
        }

        $dependencias['unidades'] = $unidades;

        return $dependencias;
    }

    /**
     * Criar usuário
     *
     * @param Usuario $usuario
     * @param array $dados
     *
     * @return Usuario
     * @throws \ReflectionException
     */
    public function criar(Usuario $usuario, $dados)
    {
        // Seta cpf como senha padrão se senha não for informada e tiver cpf
        if (!isset($dados['senha']) && !empty($dados['cpf'])) {
            $dados['senha'] = Mascarado::removerMascara($dados['cpf']);
        }

        // Transforma o registro do usuário em permanente
        // Altera os dados do usuário
        $usuario->transformarPermanente($dados);

        return $usuario;
    }

    /**
     * Alterar usuário
     *
     * @param int $id
     * @param array $dados
     *
     * @return Usuario
     */
    public function alterar($id, $dados)
    {
        $registroUsuario = Usuario::findOrFail($id);

        // Seta cpf como senha padrão se senha não for informada e tiver cpf
        if (!$registroUsuario->senha && !empty($dados['cpf'])) {
            $dados['senha'] = Mascarado::removerMascara($dados['cpf']);
        }

        if (!$registroUsuario->update($dados)) {
            return false;
        }

        return $registroUsuario;
    }

    /**
     * Excluir usuário
     *
     * @param int $id
     *
     * @return bool
     */
    public function excluir($id)
    {
        $usuario = Usuario::findOrFail($id);

        return $usuario->delete();
    }

    /**
     * Registra o aceite dos termos de uso
     *
     * @param int @nucUsuarioId
     *
     * @return Usuario
     */
    public function registrarAceiteTermosUso($nucUsuarioId)
    {
        $usuario = Usuario::find($nucUsuarioId);
        $usuario->update(['aceitou_termos_uso' => true]);

        return $usuario;
    }
}
