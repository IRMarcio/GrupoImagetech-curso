<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

    }

    public function excluirVariosRegistros(Collection $registros)
    {
        DB::beginTransaction();
        foreach ($registros as $registro) {
            $excluido = $registro->delete();
            if (!$excluido) {
                DB::rollback();

                return false;
            }
        }
        DB::commit();

        return true;
    }

    /**
     * Trata o direcionamento da pagina apos a adição de um conteúdo.
     *
     * @param string $acao
     * @param string $rota
     * @param $registro
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function tratarRedirecionamentoCrud($acao, $rota, $registro)
    {
        switch ($acao) {
            case 'salvar_adicionar':
                return redirect()->route("$rota.adicionar");
                break;
            case 'salvar_visualizar':
                return redirect()->route("$rota.alterar", $registro);
                break;
            default:
                return redirect()->route("$rota.index");
                break;
        }
    }
}
