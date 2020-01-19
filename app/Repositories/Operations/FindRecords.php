<?php

namespace App\Repositories\Operations;
use Illuminate\Support\Collection;

/**
 * Trait utilizada em repositórios que contém vários métodos de busca úteis que se repetem muitas vezes.
 *
 * @package App\Repositories\Operations
 */
trait FindRecords
{

    /**
     * Retorna uma collection contendo registros do eloquent buscados pelo id.
     *
     * @param array $ids Lista de ids para buscar os registros.
     *
     * @return Collection
     */
    public function buscarVariosPorId(array $ids)
    {
        return $this->newQuery()->whereIn('id', $ids)->get();
    }

    /**
     * Retorna todos os registros ordenados.
     *
     * @param string $campo Nome do campo para ordenar os registros.
     * @param string $ordem A ordem para buscar os registros.
     *
     * @return Collection
     */
    public function buscarTodosOrdenados($campo = 'descricao', $ordem = 'ASC')
    {
        return $this->newQuery()->orderBy($campo, $ordem)->get();
    }

}
