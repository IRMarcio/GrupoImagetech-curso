<?php

namespace App\Repositories;

use App\Models\Curso;

class CursoRepository extends CrudRepository
{

    protected $modelClass = Curso::class;

}
