<?php

namespace App\Repositories\Operations;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReadRecords.
 */
trait ReadRecords
{

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int $take
     * @param bool $paginate
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAll($take = 15, $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * Retorna o primeiro registro.
     *
     * @param string $order
     * @param string $direction
     *
     * @return Model
     */
    public function getFirst($order = 'id', $direction = 'ASC')
    {
        return $this->newQuery()->orderBy($order, $direction)->first();
    }

    /**
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function pluck($column, $key = null)
    {
        return $this->newQuery()->lists($column, $key);
    }

    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param int $id
     * @param bool $fail
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByID($id, $fail = true)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }

        return $this->newQuery()->find($id);
    }
}
