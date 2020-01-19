<?php

namespace App\Repositories;

use App\Models\SituacaoUsuario;

class SituacaoUsuarioRepository extends CrudRepository
{

    protected $modelClass = SituacaoUsuario::class;

    /**
     * Busca uma das situações de usuário pelo seu slug.
     *
     * @param string $slug
     *
     * @return SituacaoUsuario
     */
    public function buscarPorSlug($slug)
    {
        return $this->newQuery()->whereSlug($slug)->first();
    }
}
