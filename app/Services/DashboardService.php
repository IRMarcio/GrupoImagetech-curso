<?php


namespace App\Services;

use App\Models\Secao;
use App\Models\Unidade;
use App\Repositories\Contracts\Repository;
use App\Traits\DashboardAgenteTrait;
use Faker\Test\Provider\UserAgentTest;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;

class DashboardService
{

    use DashboardAgenteTrait;

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    /**
     * @var CatMat
     */
    private $catMat;

    /**
     * @var EstoqueMovimento
     */
    private $movimento;

    /**
     * @var EstoqueInventario
     */
    private $estoqueInventario;

    /**
     * @var ListaEmbalagensProdutos
     */
    private $transferencia;

    public function __construct(
        SessaoUsuario $sessaoUsuario
    ) {
        $this->sessaoUsuario = $sessaoUsuario;
    }

    /**
     *
     * */
    public
    function getValuesDashboard(): Collection
    {
        $usuarioLogado = auth()->user();
        if (!$usuarioLogado->super_admin) {
            $filtros['unidade_id'] = $this->sessaoUsuario->unidade()->id;
        }

        return $this->getData();
    }

    /**
     *
     * */
    private
    function getData(): Collection
    {
        $this->setCentro();

        return $this->formatDataDashboard();
    }
}
