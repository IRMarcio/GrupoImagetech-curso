<?php

namespace App\Repositories;

use App\Models\Auditoria;


class AuditoriaRepository extends CrudRepository
{

    protected $modelClass = Auditoria::class;
}
