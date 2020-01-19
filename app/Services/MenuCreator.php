<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Collection;

/**
 * Responsável pela criação do menu do sistema.
 *
 * @package App\Services
 */
class MenuCreator
{

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(SessaoUsuario $sessaoUsuario)
    {
        $this->sessaoUsuario = $sessaoUsuario;
    }

    /**
     * Carrega o menu do módulo da sessão.
     *
     * @return string
     * @throws \Throwable
     */
    public function carregar()
    {
        // Verifica se menu está na sessão
        $menus = $this->sessaoUsuario->menu();

        if (!$menus) {
            $menus = $this->buscarMenus();
            $this->sessaoUsuario->atualizarDados('menu', $menus);
        }

        $view = $this->renderizarView($menus);

        return $view;
    }

    /**
     * Carrega os menus.
     *
     * @return Collection
     */
    private function buscarMenus()
    {
        return Menu::with('filhos')->whereNull('menu_id')->orderBy('ordem', 'ASC')->get();
    }

    /**
     * Renderiza as views do menu.
     *
     * @param Collection $menus
     *
     * @return string
     * @throws \Throwable
     */
    private function renderizarView($menus)
    {
        return view('partials.menu.menu_itens', compact('menus'))->render();
    }
}
