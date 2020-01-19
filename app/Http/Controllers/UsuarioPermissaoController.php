<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\Usuario;
use App\Services\GerenciaPermissoes;

class UsuarioPermissaoController extends Controller
{

    /**
     * @var GerenciaPermissoes
     */
    private $gerenciaPermissoes;

    public function __construct(GerenciaPermissoes $gerenciaPermissoes)
    {
        parent::__construct();
        
        $this->gerenciaPermissoes = $gerenciaPermissoes;
    }

    /**
     * Exibe a tela para gerenciar as permissões específicas de um usuário.
     *
     * @param Usuario $usuario
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Usuario $usuario)
    {
        $perfis = $usuario->load('perfis.unidade')->perfis;

        if ($perfis) {
            $perfis = $perfis->groupBy(function ($perfil) {
                return $perfil->unidade->descricao;
            })->sortBy(function ($dados, $key) {
                return $key;
            });
        }
        return view('usuario.permissoes', compact('perfis', 'usuario'));
    }

    /**
     * Salva as permissões especificas para o usuário.
     *
     * @param Usuario $usuario
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function salvar(Usuario $usuario)
    {
        $rotas = request('rotas', []);
        $perfilId = request('perfil_id');

        $this->gerenciaPermissoes->salvarExcecoes($usuario, $perfilId, $rotas);
        flash('As permissões para o usuário foram salvas com sucesso.')->success();

        return back();
    }
}
