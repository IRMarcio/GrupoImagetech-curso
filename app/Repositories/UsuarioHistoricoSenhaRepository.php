<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use App\Models\UsuarioHistoricoSenha;

class UsuarioHistoricoSenhaRepository extends CrudRepository
{

    protected $modelClass = UsuarioHistoricoSenha::class;

    /**
     * Retorna todas as senhas já utilizadas por um usuário no sistema.
     *
     * @param int $id ID do usuário.
     *
     * @return Collection
     */
    public function buscarTodasSenhas($id)
    {
        return $this->newQuery()->where('usuario_id', $id)->orderBy('created_at', 'DESC')->get();
    }

}
