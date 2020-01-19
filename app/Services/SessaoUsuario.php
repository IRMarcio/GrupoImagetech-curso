<?php

namespace App\Services;

use App\Models\Rota;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use stdClass;

/**
 * Essa classe salva na sessão dados pré-configurados do usuário entre outras informações.
 *
 * @package App\Services
 */
class SessaoUsuario
{
    /**
     * Chave utilizada na sessão para guardar dados.
     *
     * @var string
     */
    protected $keyDados = 'sessao_usuario';

    /**
     * Retorna da sessão os dados armazenados.
     *
     * @param string|null $key
     *
     * @return stdClass|string
     */
    public function dados($key = null)
    {

        $dados = session($this->keyDados);
        if (!is_null($key)) {
            return isset($dados->$key) ? $dados->$key : null;
        }
        return $dados;
    }

    /**
     * Atualiza na session os dados armazenados.
     *
     * @param $dados
     */
    private function atualizarDadosArmazenados($dados)
    {
        session([$this->keyDados => $dados]);
    }

    /**
     * Seta as Usuarios na session quando elas não estiverem presentes ainda.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function setarRotas()
    {
        $rotas = Rota::with(['perfis', 'excecoes', 'tipo'])->get();
        $this->atualizarDados('rotas', $rotas);

        return $rotas;
    }

    /**
     * Atualiza na sessão algum dado armazenado.
     *
     * @param string $key
     * @param array $dados
     */
    public function atualizarDados($key, $dados)
    {
        $dadosSessao = session($this->keyDados);

        if (is_null($dadosSessao)) {
            $dadosSessao = new StdClass();
        }
        $dadosSessao->{$key} = $dados;

        $this->atualizarDadosArmazenados($dadosSessao);
    }

    /**
     * Retorna o menu.
     */
    public function menu()
    {
        return $this->dados('menu');
    }

    /**
     * Retorna as rotas.
     */
    public function rotas()
    {
        return $this->dados('rotas');
    }

    /**
     * Retorna o perfil ativo do usuário.
     */
    public function perfil()
    {
        return $this->dados('perfil_ativo');
    }

    /**
     * Retorna a unidade.
     */
    public function unidade()
    {
        return $this->dados('unidade');
    }

    /**
     * Retorna a Centro de Distribuição.
     */
    public function centroDistribuicao()
    {
        return $this->dados('centro_distribuicao');
    }

    /**
     * Retorna a Dados de Pedidos do Centro de Distribuição Atual.
     * @return array|stdClass|string
     */
    public function dashBoardPedidos()
    {
        return $this->dados('pedidos_dashboard');
    }

    /**
     * Retorna a Dados de Pedidos do Centro de Distribuição Atual.
     * @return array|stdClass|string
     */
    public function dashBoardRequerimento()
    {
        return $this->dados('requerimentos_dashboard');
    }


    /**
     * Verifica se o usuário logado necessita escolher a unidade ao logar.
     *
     * @param Usuario $usuario
     *
     * @return bool
     */
    public function necessitaSelecao($usuario)
    {
        // Se for lotado somente em uma unidade e tiver somente um perfil
        if (isset($usuario->perfis)) {
            $unidades = $usuario->unidades();

            // Se estiver lotado em mais de uma unidade, já manda para seleção
            if ($unidades->count() != 1) {
                return true;
            }

            // Se estiver lotado somente em uma unidade, verifica quantos perfis diferentes de lotação usuário possui
            // Ex: função de médico em lot1, função de médico em lot2, função de recepcionista em lot3 = 2 funções
            $perfis = $usuario->perfisUnidade($unidades->first()->id, true);

            // Se tiver somente 1 perfil, não necessita de seleção
            if ($perfis->count() == 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * Verifica se usuário está lotado somente em uma unidade para tentar trazer dados para pré-seleção
     *
     * @param Usuario $usuario
     *
     * @return array
     */
    public function preSelecao(Usuario $usuario = null)
    {
        $preSelecao = ['unidade_id' => null, 'perfil_id' => null, 'perfis' => collect()];

        if (is_null($usuario)) {
            return $preSelecao;
        }

        // Unidades onde o usuário está lotado
        $unidades = $usuario->unidades();

        // Se estiver lotado em mais de uma, retorna tudo vazio
        if ($unidades->count() != 1) {
            return $preSelecao;
        }

        // Já seta a unidade para pré-seleção
        $preSelecao['unidade_id'] = $unidades->first()->id;

        // Busca os perfis para pré-carregamento
        $preSelecao['perfis'] = $usuario->perfisUnidade($preSelecao['unidade_id'], true);

        // Se só tiver um perfil, seta para pré-carregamento e já retorna
        if ($preSelecao['perfis']->count() === 1) {
            $preSelecao['perfil_id'] = $preSelecao['perfis']->first()->id;
            return $preSelecao;
        }

        return $preSelecao;
    }

    /**
     * Retorna os perfis das lotações do profissional na unidade informada
     *
     * @param Usuario $usuario
     * @param int $unidadeId
     * @param boolean $preSelecao
     *
     * @return Collection
     */
    public function perfisUnidadeUsuarioLotado(Usuario $usuario, $unidadeId, $preSelecao = false)
    {
        $perfis = collect();

        if ($usuario) {
            // Busca os perfis para pré-carregamento
            $perfis = $usuario->perfisUnidade($unidadeId, true);

            // Se só tiver um perfil, seta para pré-carregamento e já retorna
            if ($perfis->count() === 1 && $preSelecao) {
                return $perfis;
            }
        }

        return $perfis;
    }
}
