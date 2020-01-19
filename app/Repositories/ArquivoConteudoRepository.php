<?php

namespace App\Repositories;

use App\Models\ArquivoConteudo;


class ArquivoConteudoRepository extends CrudRepository
{

    protected $modelClass = ArquivoConteudo::class;
}
