<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\TabArmazem;
use App\Models\TabCentroDistribuicao;
use App\Models\TabEndLocacao;
use App\Models\Unidade;
use App\Traits\CreateEnderecoAlocacaoTrait;
use App\Traits\UpdateTrasnferenciaEnderecoDataTrait;
use Mpdf\Tag\Th;
use phpDocumentor\Reflection\Types\Boolean;

class GerenciaCentroDistribuicao
{

    /**
     * @var SessaoUsuario
     */
    private $sessaoUsuario;

    public function __construct(SessaoUsuario $sessaoUsuario)
    {
        $this->sessaoUsuario = $sessaoUsuario;
    }

    use
        UpdateTrasnferenciaEnderecoDataTrait,
        CreateEnderecoAlocacaoTrait;

    protected $colectEndereco = [];

    /**
     * Carrega as dependências para cadastro/alteração de unidade
     *
     * @param TabCentroDistribuicao $centro_distribuicao
     *
     * @return array
     */
    public function carregarDependencias(TabCentroDistribuicao $centro_distribuicao = null)
    {

        $estados = Estado::orderBy('uf', 'ASC')->get();
        $municipios = null;

        $unidades = Unidade::doesnthave('centro')->orderBy('descricao', 'ASC')->get();

        if (!$centro_distribuicao->unidadeCentro->isEmpty())
            $unidades = $centro_distribuicao->unidadeCentro;

        if (!is_null($centro_distribuicao->endereco) && $centro_distribuicao->endereco->municipio_id) {
            $municipios = Municipio::where('uf_id', $centro_distribuicao->endereco->municipio->uf_id)->get();
        }

        return compact('estados', 'municipios', 'unidades');
    }

    /**
     * Carrega as dependências para cadastro/alteração de unidade
     *
     * @param TabCentroDistribuicao $centro_distribuicao
     *
     * @return array
     */
    public function carregarDependenciasArmazem($centro_distribuicao = null)
    {

        $estados = Estado::orderBy('uf', 'ASC')->get();
        $municipios = null;

        if (!is_null($centro_distribuicao->endereco) && $centro_distribuicao->endereco->municipio_id) {
            $municipios = Municipio::where('uf_id', $centro_distribuicao->endereco->municipio->uf_id)->get();
        }

        return compact('estados', 'municipios');
    }

    /**
     *
     * */
    public function createEnderecoAlocacao()
    {
        /*Trait - CreateEnderecoAlocacao*/
        $this->setEstruturaCadastro();
        return $this->getCadastro();
    }

    /**
     * Criar unidade
     *
     * @param array $dados
     *
     * @return \App\Models\TabCentroDistribuicao
     * @throws ValidationException
     */
    public function criar($centro_distribuicao, $dados)
    {
        if (method_exists($centro_distribuicao, 'transformarPermanente')) {
            $centro_distribuicao->transformarPermanente($dados);
            $centro_distribuicao->unidadeCentro()->sync(request()->input('unidade'));
            $this->getEndLocacao($centro_distribuicao);
        } else {
            $centro_distribuicao->create($dados);
            $centro_distribuicao->unidadeCentro()->sync(request()->input('unidade'));
            $this->getEndLocacao($centro_distribuicao);
        }


        return $centro_distribuicao;
    }

    /**
     * Alterar unidade
     *
     * @param int $id
     * @param array $dados
     *
     * @return \App\Models\TabCentroDistribuicao
     * @throws ValidationException
     */
    public function alterar($id, $dados)
    {
        $centro_distribuicao = TabCentroDistribuicao::findOrFail($id);
        $centro_distribuicao->unidadeCentro()->sync(request()->input('unidade'));
        $centro_distribuicao->update($dados);
        $centro_distribuicao->endereco->update($dados);


        return $centro_distribuicao;
    }

    /**
     * Alterar unidade
     *
     * @param int $id
     * @param array $dados
     *
     * @return \App\Models\TabCentroDistribuicao
     * @throws ValidationException
     */
    public function alterarArmazem($id, $idCd, $dados)
    {
        $centro_distribuicao = TabCentroDistribuicao::findOrFail($idCd);
        $armazem = $centro_distribuicao->armazem->find($id);
        $armazem->update($dados);
        $armazem->endereco->update($dados);

        return $armazem;
    }

    /**
     * Exclui uma unidade.
     *
     * @param int $id
     *
     * @return bool|null
     */
    public function excluir($id)
    {
        return TabCentroDistribuicao::find($id)->delete();
    }

    /**
     * Gerar Endereços de locacao Automático -> depois rever o conceito da estrutura.
     *
     * @param int $id
     *
     * @return bool|null
     */
    public function getEndLocacao($centro_distribuicao)
    {
        $this->colectEndereco = [];
        $area = request()->area;
        $rua = request()->rua;
        $modulo = request()->modulo;
        $nivel = request()->nivel;
        $vao = request()->vao;
        $codigoVao =  1;

        for ($a = 1; $a <= $area; $a++) {
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

        return $centro_distribuicao->endAlocacao()->createMany($this->colectEndereco);
    }

    /**
     * Gerar Collect de Endereços para Gravar no Banco;
     *
     * @param int $a ,$r,$m,$n,$codigoVao;
     * @return null;
     */
    private function createAlocacao($a, $r, $m, $n, $codigoVao)
    {
        $a = str_pad($a, 2, '0', STR_PAD_LEFT);
        $r = str_pad($r, 2, '0', STR_PAD_LEFT);
        $m = str_pad($m, 3, '0', STR_PAD_LEFT);
        $n = str_pad($n, 2, '0', STR_PAD_LEFT);
        return array_push($this->colectEndereco, ['area' => $a, 'rua' => $r, 'modulo' => $m, 'nivel' => $n, 'vao' => $codigoVao]);
    }

    /**
     * Gera Estrutura de atualização de Endereço do centro de distribuição bem como ->
     * Transferência de Mercadoria entre as alocações.
     * @param $data ;
     *
     * @return GerenciaCentroDistribuicao
     */
    public function updateEndereco($data)
    {
        $this->setData($data);
        return $this->getUpdateTransferenciaEndereco();
    }

    /**
     *
     * */
    public function getUpdateTransferenciaEndereco()
    {
        return $this->gerarEstruturaUpdateTransferencia();
    }

    /**
     * @return Boolean;
     * *@see Remove Endereço de Alocação do Banco do Centro de Distribuição
     */
    public function deleteEndereco()
    {
        return TabEndLocacao::find(request()->input('id'))->delete();
    }
}
