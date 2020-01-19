<?php

namespace App\Services;

use App\Models\Rota;
use DB;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\Perfil;
use App\Models\PermissaoExcecao;
use App\Models\Usuario;

class GerenciaPermissoes
{

    /**
     * Carrega a view de gerenciamento de permissões.
     *
     * @param array $filtros
     *
     * @return string
     */
    public function carregarViewGerenciamento($filtros = [])
    {
        // Descobre o perfil
        if (isset($filtros['perfil_id'])) {
            $perfil = Perfil::with('permissoes')->find($filtros['perfil_id']);
        }

        $view = $this->view();

        // Carrega as permissoes que ja foram setadas para o perfil
        $permissoes = [];
        if (isset($perfil)) {
            $permissoes = $perfil->permissoes->pluck('id')->toArray();
        }

        // Caso tenha que carregar as excecoes também
        if (isset($filtros['excecoes']) && isset($filtros['usuario_id']) && $filtros['excecoes']) {
            $usuario = Usuario::find($filtros['usuario_id'])->load('perfis.permissoes');
            $perfil = $usuario->perfis->where('id', $filtros['perfil_id'])->first();
            $perfilUsuarioId = $perfil->pivot->id;

            $excecoes = PermissaoExcecao::where('perfil_usuario_id', $perfilUsuarioId)->get();
            $excecoes->each(function ($excecao) use (&$permissoes) {
                if ($excecao->excecao == 1) {
                    $permissoes[] = $excecao->rota_id;
                } else {
                    if (($key = array_search($excecao->rota_id, $permissoes)) !== false) {
                        unset($permissoes[$key]);
                    }
                }
            });
        }


        $view->with(compact('permissoes'));

        return $view->render();
    }

    /**
     * Retorna a view de gerenciamento de permissões.
     *
     * @return string
     */
    private function view()
    {
        $rotas = $this->carregarRotas();

        return view('partials.lista_rotas', compact('rotas'));
    }

    /**
     * Carrega as rotas.
     *
     * @return mixed
     */
    private function carregarRotas()
    {
        $rotas = Rota::with('tipo')->where('acesso_liberado', 'N')->where('desenv', 'N')->get();
        $rotas = $rotas->groupBy('tipo.descricao')->sortBy(function ($items, $key) {
            return $key;
        });

        return $rotas;
    }

    /**
     * Atualiza as permissões de um perfil.
     *
     * @param integer $perfilId
     * @param array $dados
     *
     * @return bool
     */
    public function salvar($perfilId, $dados)
    {
        try {
            $rotas = request('rotas');
            $perfil = Perfil::find($perfilId);
            $perfil->permissoes()->sync($rotas);
        }
        catch (Exception $e) {
            Log::error('Erro ao atualizar permissoes');
            Log::error($dados);
            Log::error($e);

            return false;
        }

        return true;
    }

    /**
     * Salva as permissões especificas para o perfil de um usuário.
     *
     * @param Usuario $usuario Dados do usuário
     * @param int $perfilId ID do perfil
     * @param array $dados Array com as permissões selecionadas na tela
     */
    public function salvarExcecoes(Usuario $usuario, $perfilId, $dados)
    {
        $usuario->load('perfis.permissoes');

        $perfil = $usuario->perfis->where('id', $perfilId)->first();
        $perfilUsuarioId = $perfil->pivot->id;

        DB::table('excecao')->where('perfil_usuario_id', $perfilUsuarioId)->delete();

        // Lista as permissoes atuais do perfil do usuário
        $permissoes = $perfil->permissoes->pluck('id')->toArray();

        // Agora separamos as rotas que sao consideradas como permite e não permite
        $naoPermite = array_diff($permissoes, $dados);
        $naoPermite = $this->preparaExcecoes($naoPermite, $perfilUsuarioId, 0);

        $permite = array_diff($dados, $permissoes);
        $permite = $this->preparaExcecoes($permite, $perfilUsuarioId, 1);

        PermissaoExcecao::insert(array_merge($naoPermite, $permite));
    }

    /**
     * Formata as excecoes de permissões para salvar.
     *
     * @param array $naoPermite
     * @param int $perfilUsuarioId
     * @param int $excecao
     *
     * @return Collection
     */
    private function preparaExcecoes($naoPermite, $perfilUsuarioId, $excecao)
    {
        return collect($naoPermite)->transform(function ($valor) use ($excecao, $perfilUsuarioId) {
            return [
                'rota_id'           => $valor,
                'excecao'               => $excecao,
                'perfil_usuario_id' => $perfilUsuarioId,
                'created_at'            => now(config('app.timezone')),
                'updated_at'            => now(config('app.timezone'))
            ];
        })->toArray();
    }
}
