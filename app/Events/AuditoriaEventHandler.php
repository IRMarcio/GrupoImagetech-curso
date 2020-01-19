<?php

namespace App\Events;

use App\Services\Auditor;
use App\Services\GerenciaSession;

/**
 * Escuta alguns eventos do eloquent e fica a par de todos os registros que são criados, alterados e excluídos.
 * Para cada ação, adiciona um registro de auditoria para posterior consulta.
 *
 * @package App\Events
 */
class AuditoriaEventHandler
{

    /**
     * @var Auditor
     */
    private $auditor;

    /**
     * @var GerenciaSession
     */
    private $gerenciaSession;

    /**
     * As alterações realizadas nessas tabelas não são auditadas.
     *
     * @var array
     */
    private $ignorarTabelas = [
        'auditoria', 'arquivo_conteudo', 'auditoria_acao', 'notifications', 'jobs', 'sessions'
    ];

    public function __construct(Auditor $auditor, GerenciaSession $gerenciaSession)
    {
        $this->auditor = $auditor;
        $this->gerenciaSession = $gerenciaSession;
    }

    /**
     * Adiciona um registro de adição na auditoria relacionando com o registro sendo adicionado.
     *
     * @param string $evento
     * @param array $dados
     *
     * @return bool
     * @throws \Exception
     */
    public function onEloquentCreating($evento, $dados)
    {
        if (!auth()->check() || $this->gerenciaSession->sessaoUsuarioEstaBloqueada(auth()->user()->id)) {
            return true;
        }


        $dados = $dados['model'];
        if (!in_array($dados->getTable(), $this->ignorarTabelas)) {
            $alterado = $dados->getAttributes();
            $this->auditor->adicionaAlteracoes($dados, $alterado, [], 'I');
        }

        return true;
    }

    /**
     * Adiciona um registro de alteração na auditoria relacionando com o registro sendo atualizado.
     *
     * @param $evento
     * @param $dados
     *
     * @return bool
     * @throws \Exception
     */
    public function onEloquentUpdating($evento, $dados)
    {
        if (!auth()->check() ||
            $this->gerenciaSession->sessaoUsuarioEstaBloqueada(auth()->user()->id) ||
            strpos(request()->route()->getName(), 'logout') !== false) {
            return true;
        }

        $dados = $dados['model'];
        if (!in_array($dados->getTable(), $this->ignorarTabelas)) {
            $alterado = $dados->getDirty();
            $original = array_intersect_key($dados->getOriginal(), $alterado);

            $this->auditor->adicionaAlteracoes($dados, $alterado, $original, 'U');
        }

        return true;
    }

    /**
     * Adiciona um registro de exclusão na auditoria relacionando com o registro sendo excluido.
     *
     * @param $evento
     * @param $dados
     *
     * @return bool
     * @throws \Exception
     */
    public function onEloquentDeleting($evento, $dados)
    {
        if (!auth()->check() || $this->gerenciaSession->sessaoUsuarioEstaBloqueada(auth()->user()->id)) {
            return true;
        }

        $dados = $dados['model'];
        if (!in_array($dados->getTable(), $this->ignorarTabelas)) {
            $original = $dados->getOriginal();
            $this->auditor->adicionaAlteracoes($dados, [], $original, 'D');
        }

        return true;
    }

    /**
     * Ao utilizar o attach em um pivot.
     *
     * @param $evento
     * @param $dados
     *
     * @return bool
     * @throws \Exception
     */
    public function onEloquentPivotAttached($evento, $dados)
    {
        if (!auth()->check() || $this->gerenciaSession->sessaoUsuarioEstaBloqueada(auth()->user()->id)) {
            return true;
        }

        $model = $dados['model'];
        if (!in_array($model->getTable(), $this->ignorarTabelas)) {
            $teste = collect($dados['pivotIds'])->keyBy(function () use ($dados) {
                return $dados['relation'];
            })->toArray();

            $this->auditor->adicionaAlteracoes($model, $teste, [], 'I');
        }

        return true;
    }

    /**
     * Ao utilizar o attach em um pivot.
     *
     * @param $evento
     * @param $dados
     *
     * @return bool
     * @throws \Exception
     */
    public function onEloquentPivotDetached($evento, $dados)
    {
        if (!auth()->check() || $this->gerenciaSession->sessaoUsuarioEstaBloqueada(auth()->user()->id)) {
            return true;
        }

        $model = $dados['model'];
        if (!in_array($model->getTable(), $this->ignorarTabelas)) {
            $teste = collect($dados['pivotIds'])->keyBy(function () use ($dados) {
                return $dados['relation'];
            })->toArray();

            $this->auditor->adicionaAlteracoes($model, [], $teste, 'D');
        }

        return true;
    }

    /**
     * Ao atualizar um registro pivot.
     *
     * @param $evento
     * @param $dados
     *
     * @return bool
     * @throws \Exception
     */
    public function onUpdateExistingPivot($evento, $dados)
    {
        if (!auth()->check() || $this->gerenciaSession->sessaoUsuarioEstaBloqueada(auth()->user()->id)) {
            return true;
        }

        $model = $dados['model'];
        if (!in_array($model->getTable(), $this->ignorarTabelas)) {
            $teste = collect($dados['pivotIds'])->keyBy(function () use ($dados) {
                return $dados['relation'];
            })->toArray();

            $this->auditor->adicionaAlteracoes($model, $teste, [], 'I');
        }

        return true;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        if (!app()->runningInConsole()) {
            $events->listen('eloquent.created: *', 'App\Events\AuditoriaEventHandler@onEloquentCreating');
            $events->listen('eloquent.deleted: *', 'App\Events\AuditoriaEventHandler@onEloquentDeleting');
            $events->listen('eloquent.updated: *', 'App\Events\AuditoriaEventHandler@onEloquentUpdating');
            $events->listen('eloquent.pivotAttached: *', 'App\Events\AuditoriaEventHandler@onEloquentPivotAttached');
            $events->listen('eloquent.pivotDetached: *', 'App\Events\AuditoriaEventHandler@onEloquentPivotDetached');
            $events->listen('eloquent.pivotUpdated: *', 'App\Events\AuditoriaEventHandler@onUpdateExistingPivot');
        }
    }
}
