<?php

namespace App\Repositories;

use App\Repositories\CrudRepository;
use Illuminate\Support\Collection;
use App\Models\Municipio;

class MunicipioRepository extends CrudRepository
{

    protected $modelClass = Municipio::class;

    /**
     * Retorna todos os municípios de um estado de forma ordenada.
     *
     * @param int $ufId Id do estado.
     *
     * @return Collection
     */
    public function buscarOrdenadoPeloEstado(int $ufId)
    {
        return $this->newQuery()->where('uf_id', $ufId)->orderBy('descricao', 'ASC')->get();
    }

}
