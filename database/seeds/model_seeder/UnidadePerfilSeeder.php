<?php

use App\Http\Controllers\CentroDistribuicaoController;
use App\Http\Controllers\UnidadeController;
use App\Models\Perfil;
use App\Models\TabCentroDistribuicao;
use App\Models\Unidade;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Log;

class UnidadePerfilSeeder extends Seeder
{

    /**
     * @var Faker
     */
    private $faker;

    protected $colectEndereco = [];

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     *
     * */
    public function run()
    {

        $app = app();


        $json = File::get(base_path('database/seeds/data/unidade_perfil_cd/data.json'));
        $registros = json_decode($json, true);

        $controller = $app->make(UnidadeController::class);
        foreach ($registros as $registro) {
            /** Seleciona Unidade fill de Registro*/
            $unidadeAtual = $registro;
            /** Separa CD do JSON para gravar no banco Unidade*/
            unset($unidadeAtual['cd']);
            /** Gera Unidade Temporária*/
            $unidade = Unidade::gerarTemporario();
            /** Chama Função addSeederRequest de UnidadeController para Gerar estrura de Arquivo e Gravar no Banco*/
            $controller->callAction('addSeederRequest', [$unidadeAtual, $unidade, $this->getSecao($unidade)]);
            /** Prepara Dados de Perfil para Gravar no Banco*/
            $perfils = $this->getPerfil($unidade);
            Perfil::create($perfils);

            /** Prepara estrutura de Endereço no Banco para Gravar Centro de Distribuição*/
            $endereco = $registro['cd'];
            unset($endereco['endereco']);
            unset($endereco['deposito']);

            $centro_distribuicao = TabCentroDistribuicao::create($endereco);
            $centro_distribuicao->unidadeCentro()->sync($unidade->id);
            $this->getEndLocacao($centro_distribuicao, $registro['cd']['deposito']);
            $centro_distribuicao->endereco()->create($registro['cd']['endereco']);

        }

    }

    /**
     *
     * @param $unidade
     *
     * @return array
     */
    function getSecao($unidade): array
    {
        return [
            "descricao"  => "Sessão Administrativa",
            "ativo"      => 1,
            "unidade_id" => $unidade->id
        ];
    }

    /**
     *
     * @param $unidade
     *
     * @return array
     */
    function getPerfil($unidade): array
    {
        return [
            "nome"       => "Perfil Administrativo",
            "ativo"      => "1",
            "unidade_id" => $unidade->id
        ];
    }

    /**
     * Gerar Endereços de locacao Automático -> depois rever o conceito da estrutura.
     *
     * @param $centro_distribuicao
     * @param $dados
     *
     * @return bool|null
     */
    function getEndLocacao($centro_distribuicao, $dados)
    {
        $this->colectEndereco = [];
        $area = $dados['area'];
        $rua = $dados['rua'];
        $modulo = $dados['modulo'];
        $nivel = $dados['nivel'];
        $vao = $dados['vao'];
        $codigoVao = 1;

        for ($a = 1; $a <= $area; $a++) {
            for ($r = 1; $r <= $rua; $r++) {
                for ($m = 1; $m <= $modulo; $m++) {
                    for ($n = 1; $n <= $nivel; $n++) {
                        for ($v = 1; $v <= $vao; $v++) {
                            $this->createAlocacao($a, $r, $m, $n, $v, $centro_distribuicao);
                            $codigoVao++;
                        }
                    }
                }
            }
        }

        return $centro_distribuicao->endAlocacao()->createMany($this->colectEndereco);
    }

    /**
     *
     * @param $a
     * @param $r
     * @param $m
     * @param $n
     * @param $codigoVao
     * @param $centro_distribuicao
     */
    function createAlocacao($a, $r, $m, $n, $codigoVao, $centro_distribuicao)
    {
        $a = str_pad($a, 2, '0', STR_PAD_LEFT);
        $r = str_pad($r, 2, '0', STR_PAD_LEFT);
        $m = str_pad($m, 3, '0', STR_PAD_LEFT);
        $n = str_pad($n, 2, '0', STR_PAD_LEFT);
        array_push($this->colectEndereco, ['area' => $a, 'rua' => $r, 'modulo' => $m, 'nivel' => $n, 'vao' => $codigoVao]);

    }

}
