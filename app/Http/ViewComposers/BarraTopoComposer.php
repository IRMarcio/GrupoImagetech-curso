<?php

namespace App\Http\ViewComposers;

use App\Services\SessaoUsuario;
use Illuminate\Contracts\View\View;

class BarraTopoComposer
{

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(SessaoUsuario $sessaoUsuario)
    {
        $this->sessaoUsuario = $sessaoUsuario;
    }

    public function compose(View $view)
    {

        $qtdPerfis = auth()->user()->perfis()->count();
        $perfilAtivo = $this->sessaoUsuario->perfil();

        return $view->with(compact('perfilAtivo', 'qtdPerfis'));
    }
}
