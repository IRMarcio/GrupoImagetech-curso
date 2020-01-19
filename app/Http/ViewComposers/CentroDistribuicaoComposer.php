<?php

namespace App\Http\ViewComposers;

use App\Models\TabCentroDistribuicao;
use App\Services\SessaoUsuario;
use Illuminate\Contracts\View\View;

class CentroDistribuicaoComposer
{

    /**
     * @var TabCentroDistribuicao
     */
    private $centroDistribuicao;

    public function __construct(TabCentroDistribuicao $centroDistribuicao)
    {
        $this->centroDistribuicao = $centroDistribuicao;
    }

    public function compose(View $view)
    {
        $matriz = $this->centroDistribuicao->whereMatriz(1)->get()->isEmpty();

        return $view->with(compact('matriz'));
    }
}
