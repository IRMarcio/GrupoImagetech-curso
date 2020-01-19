<?php

namespace App\Repositories;

use App\Models\Arquivo;


class ArquivoRepository extends CrudRepository
{

    protected $modelClass = Arquivo::class;
}
