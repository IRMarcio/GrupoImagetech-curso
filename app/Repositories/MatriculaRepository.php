<?php

namespace App\Repositories;


use App\Models\Matricula;

class MatriculaRepository extends CrudRepository
{

    protected $modelClass = Matricula::class;

}
