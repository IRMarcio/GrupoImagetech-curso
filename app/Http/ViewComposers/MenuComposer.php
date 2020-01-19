<?php

namespace App\Http\ViewComposers;

use App\Services\MenuCreator;
use Illuminate\Contracts\View\View;

class MenuComposer
{

    /**
     * @var MenuCreator
     */
    private $menuCreator;

    public function __construct(MenuCreator $menuCreator)
    {
        $this->menuCreator = $menuCreator;
    }

    public function compose(View $view)
    {
        $usuario = auth()->user();

        // Carrega o menu do módulo ativo no sistema
        $menuRenderizado = $this->menuCreator->carregar();

        return $view->with(compact('menuRenderizado'));
    }
}
