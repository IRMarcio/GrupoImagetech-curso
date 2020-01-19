<?php

namespace App\Repositories\Contracts;

interface Repository
{

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function newQuery();

    /**
     * Creates a Model object with the $data information.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function factory(array $data = []);
}
