<?php


namespace App\Traits;


trait CreateEnderecoAlocacaoTrait
{

    /*Set Acão que determina o tipo de estrutura de cadastros de endereços*/
    protected $acao = null;
    /*Set Centro de Distribuição Atual para preenchimento das alocações de cadastro de endereços*/
    protected $centro = null;

    /*Set query fields endereços*/
    protected $area = null;
    protected $rua = null;
    protected $modulo = null;
    protected $nivel = null;


    /**
     * @param null $centro
     */
    private function setCentro($centro): void
    {
        $this->centro = $centro;
    }

    /**
     * @param null $acao
     */
    private function setAcao($acao): void
    {
        $this->acao = $acao;
    }

    /**
     * @see Set Estrutura de Cadastro de Endereços -> (alocação);
     * */
    public function setEstruturaCadastro()
    {
        $this->setAcao(request()->input('acao'));
        $this->setCentro($this->sessaoUsuario->centroDistribuicao());
        $this->setRequestValues();
        $this->setQueryEnderecos(json_decode(request()->input('createIn'), true)['query']);
    }

    public function getCadastro()
    {

        switch ($this->acao) {
            case 'area':
                return $this->getEndLocacaoArea($this->getQuery());
                break;
            case 'rua':
                return $this->getEndLocacaoRua($this->getQuery());
                break;
            case 'modulo':
                return $this->getEndLocacaoModulo($this->getQuery());
                break;
            case 'nivel':
                return $this->getEndLocacaoNivel($this->getQuery());
                break;
            case 'vao':
                return $this->getEndLocacaoVao($this->getQuery());
                break;
            default:
                return redirect()->back();
        }

    }

    private function getQuery()
    {

        switch ($this->acao) {
            case 'area':
                return $this->centro->endAlocacao->groupBy('area')->count() + 1;
                break;
            case 'rua':
                return $this->centro->endAlocacao->where('area', $this->area)->groupBy('rua')->count() + 1;
                break;
            case 'modulo':
                $_modulo = $this->centro->endAlocacao->where('area', $this->area)->where('rua', $this->rua)->groupBy('modulo');
                $valor = $_modulo->count() + 1;
                foreach (array_keys($_modulo->toArray()) as $keys) {
                    do {
                        $valor++;
                    } while (($valor) <= (int)$keys);
                }
                return $valor;
                break;
            case 'nivel':
                $_modulo = $this->centro->endAlocacao
                    ->where('area', $this->area)
                    ->where('rua', $this->rua)
                    ->where('modulo', $this->modulo)
                    ->groupBy('nivel');
                $valor = $_modulo->count() + 1;

                foreach (array_keys($_modulo->toArray()) as $keys) {
                    if ($valor <= (int)$keys)
                        do {
                            $valor++;
                        } while (($valor) <= (int)$keys);
                }
                return $valor;
                break;
            case 'vao':
                $_modulo = $this->centro->endAlocacao
                    ->where('area', $this->area)
                    ->where('rua', $this->rua)
                    ->where('modulo', $this->modulo)
                    ->where('nivel', $this->nivel)
                    ->groupBy('vao');

                $valor = $_modulo->count() + 1;
                foreach (array_keys($_modulo->toArray()) as $keys) {
                    if ($valor <= (int)$keys)
                        do {
                            $valor++;
                        } while (($valor) <= (int)$keys);
                }
                return $valor;
                break;
        }
    }


    private function getEndLocacaoArea($x = null)
    {
        $this->colectEndereco = [];
        $area = (request()->area + $x - 1);
        $rua = request()->rua;
        $modulo = request()->modulo;
        $nivel = request()->nivel;
        $vao = request()->vao;
        $codigoVao = 1;

        for ($a = $x; $a <= $area; $a++) {
            for ($r = 1; $r <= $rua; $r++) {
                for ($m = 1; $m <= $modulo; $m++) {
                    for ($n = 1; $n <= $nivel; $n++) {
                        for ($v = 1; $v <= $vao; $v++) {
                            $this->createAlocacao($a, $r, $m, $n, $v);
                            $codigoVao += 1;
                        }
                    }
                }
            }
        }

        return $this->centro->endAlocacao()->createMany($this->colectEndereco);
    }

    private function getEndLocacaoRua($x = null)
    {
        $this->colectEndereco = [];

        $rua = (request()->rua + $x - 1);
        $modulo = request()->modulo;
        $nivel = request()->nivel;
        $vao = request()->vao;
        $codigoVao = 1;


        for ($r = $x; $r <= $rua; $r++) {
            for ($m = 1; $m <= $modulo; $m++) {
                for ($n = 1; $n <= $nivel; $n++) {
                    for ($v = 1; $v <= $vao; $v++) {
                        $this->createAlocacao($this->area, $r, $m, $n, $v);
                        $codigoVao += 1;
                    }
                }
            }
        }


        return $this->centro->endAlocacao()->createMany($this->colectEndereco);
    }

    private function getEndLocacaoModulo($x = null)
    {
        $this->colectEndereco = [];

        $modulo = (request()->modulo + $x - 1);
        $nivel = request()->nivel;
        $vao = request()->vao;
        $codigoVao = 1;

        for ($m = $x; $m <= $modulo; $m++) {
            for ($n = 1; $n <= $nivel; $n++) {
                for ($v = 1; $v <= $vao; $v++) {
                    $this->createAlocacao($this->area, $this->rua, $m, $n, $v);
                    $codigoVao += 1;
                }
            }
        }

        return $this->centro->endAlocacao()->createMany($this->colectEndereco);
    }

    private function getEndLocacaoNivel($x = null)
    {
        $this->colectEndereco = [];


        $nivel = (request()->nivel + $x - 1);
        $vao = request()->vao;
        $codigoVao = 1;

        for ($n = $x; $n <= $nivel; $n++) {
            for ($v = 1; $v <= $vao; $v++) {
                $this->createAlocacao($this->area, $this->rua, $this->modulo, $n, $v);
                $codigoVao += 1;
            }
        }


        return $this->centro->endAlocacao()->createMany($this->colectEndereco);
    }

    private function getEndLocacaoVao($x = null)
    {
        $this->colectEndereco = [];

        $vao = (request()->vao + $x - 1);
        $codigoVao = 1;

        for ($v = $x; $v <= $vao; $v++) {
            $this->createAlocacao($this->area, $this->rua, $this->modulo, $this->nivel, $v);
            $codigoVao += 1;
        }


        return $this->centro->endAlocacao()->createMany($this->colectEndereco);
    }

    /**
     *
     * */
    private function setQueryEnderecos($query)
    {
        $this->area = $query['area'];
        $this->rua = $query['rua'];
        $this->modulo = $query['modulo'];
        $this->nivel = $query['nivel'];
    }

    /**
     * @see Set request com os campos adicionais para composição da arquitetura de gravação de endereços;
     * */
    private function setRequestValues()
    {
        $_var = json_decode(request()->input('createIn'), true);
        if (isset($_var['obj']['q_area']))
            request()->request->add(['area' => (int)$_var['obj']['q_area']]);
        if (isset($_var['obj']['q_rua']))
            request()->request->add(['rua' => (int)$_var['obj']['q_rua']]);
        if (isset($_var['obj']['q_modulo']))
            request()->request->add(['modulo' => (int)$_var['obj']['q_modulo']]);
        if (isset($_var['obj']['q_nivel']))
            request()->request->add(['nivel' => (int)$_var['obj']['q_nivel']]);
        if (isset($_var['obj']['q_vao']))
            request()->request->add(['vao' => (int)$_var['obj']['q_vao']]);
    }


}