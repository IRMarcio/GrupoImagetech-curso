<?php

namespace App\Repositories;

use App\Models\Enderecamento;

class EnderecamentoRepository extends CrudRepository
{

    protected $modelClass = Enderecamento::class;

}
