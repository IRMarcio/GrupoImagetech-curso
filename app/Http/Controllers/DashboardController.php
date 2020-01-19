<?php

namespace App\Http\Controllers;

use App\Models\CatMat;
use App\Models\EstoqueInventario;
use App\Models\EstoqueMovimento;
use App\Models\ListaEmbalagensProdutos;
use App\Models\Processo;
use App\Services\DashboardService;
use App\Services\SessaoUsuario;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Collection;
use Symfony\Component\Process\Process;

class DashboardController extends Controller
{
    /**
     * @var DashboardService
     */
    private $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    /**
     * Exibe o dashboard.
     */
    public function index()
    {

        $dados = $this->service->getValuesDashboard();
        return view('dashboard', compact('dados'));
    }


}
