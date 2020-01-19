<?php

namespace App\Repositories\Operations;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait CreateRecords.
 */
trait CreateRecords
{

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data = [])
    {
        $model = $this->factory($data);

        $this->save($model);

        return $model;
    }

    /**
     * Performs the save method of the model
     * The goal is to enable the implementation of your business logic before the command.
     *
     * @param Model $model
     *
     * @return bool
     */
    public function save($model)
    {
        return $model->save();
    }

}
