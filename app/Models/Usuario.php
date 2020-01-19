<?php

namespace App\Models;

use App\Scopes\IgnorarTemporarioScope;
use App\Services\Mascarado;

/**
 * Class Usuario
 *
 * Representa um usuário no sistema.
 *
 * @package App\Models
 */
class Usuario extends BaseModelUsuario
{

    protected static $minSlugLength = 15;

    protected $table = 'usuario';

    protected $appends = [
        'atualizado_em',
        'slug_id'
    ];

    protected $casts = [
        'aceitou_termos_uso' => 'boolean',
        'super_admin'        => 'boolean',
        'gestor'             => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'gestor',
        'cpf',
        'data_nascimento',
        'email',
        'tel_celular',
        'tel_residencial',
        'super_admin',
        'senha',
        'ultimo_login',
        'ultima_alteracao_senha',
        'aceitou_termos_uso'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'senha',
        'remember_token',
    ];

    protected $dates = [
        'data_nascimento',
        'ultima_alteracao_senha'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new IgnorarTemporarioScope);
    }

    /**
     * Retorna a senha do usuário.
     *
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->attributes['senha'];
    }

    /**
     * Remove a máscara do CPF.
     *
     * @param  string  $valor
     */
    public function setCpfAttribute($valor)
    {
        $this->attributes['cpf'] = Mascarado::removerMascara($valor);
    }

    /**
     * Encripta a senha.
     *
     * @param  string  $senha
     */
    public function setSenhaAttribute($senha)
    {
        if (!is_null($senha) && !empty($senha)) {
            $this->attributes['senha'] = bcrypt($senha);
        }
    }

    /**
     * Formata campo.
     *
     * @param  string  $valor
     */
    public function setDataNascimentoAttribute($valor)
    {
        if ($valor) {
            $valor = formatarData($valor, 'Y-m-d');
        }

        $this->attributes['data_nascimento'] = $valor;
    }

    /**
     * Retorna perfil principal do usuário
     *
     * @param $ativo
     *
     * @return Perfil
     */
    public function retornarPerfilPrincipal($ativo = null)
    {
        $perfis = $this->perfis;
        if (!is_null($ativo)) {
            $perfis = $perfis->where('pivot.ativo', $ativo);
        }


        if ($perfil = $perfis->where('pivot.principal', 1)->first()) {
            return $perfil;
        } else {
            return $perfis->first();
        }

        return null;
    }

    /**
     * Verifica se o usuário tem uma ou mais situações passadas.
     *
     * @param  mixed  $situacao
     *
     * @return bool
     */
    public function temSituacao($situacao)
    {
        if (!is_array($situacao)) {
            $situacao = array_wrap($situacao);
        }

        return count($this->situacoes->whereIn('slug', $situacao)) > 0;
    }

    /**
     * Adiciona uma nova situação a um usuário.
     *
     * @param  mixed  $situacao
     */
    public function adicionarSituacao($situacao)
    {
        if (!is_array($situacao)) {
            $situacao = array_wrap($situacao);
        }

        $situacoes = SituacaoUsuario::whereIn('slug', $situacao)->get();

        $this->situacoes()->syncWithoutDetaching($situacoes);
        $this->touch();
    }

    /**
     * Retorna as situações do usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function situacoes()
    {
        return $this->belongsToMany(SituacaoUsuario::class, 'situacao_usuario_usuario', 'usuario_id', 'situacao_usuario_id')
                    ->withPivot(['created_at'])
                    ->withTimestamps();
    }

    /**
     * Remove uma situação de um usuário.
     *
     * @param  mixed  $situacao
     *
     * @return int
     */
    public function removerSituacao($situacao)
    {
        if (!is_array($situacao)) {
            $situacao = array_wrap($situacao);
        }

        $situacoes = SituacaoUsuario::whereIn('slug', $situacao)->get();

        $detached = $this->situacoes()->detach($situacoes);
        $this->touch();

        return $detached;
    }

    /**
     * Todos os perfis que o usuário tem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'perfil_usuario', 'usuario_id', 'perfil_id')
                    ->withPivot(['principal', 'ativo', 'id'])
                    ->where('perfil.ativo', 1)
                    ->withTimestamps();
    }

    /**
     * Verifica se usuário possui perfil informado
     *
     * @param  bool
     *
     * @return int $perfilId
     *
     */
    public function possuiFerfil($perfilId)
    {
        return (bool) $this->retornarPerfil($perfilId);
    }

    /**
     * Retorna perfil do usário caso possua
     *
     * @param  bool
     *
     * @return int $perfilId
     *
     */
    public function retornarPerfil($perfilId)
    {
        return $this->belongsToMany(Perfil::class, 'perfil_usuario', 'usuario_id', 'perfil_id')
                    ->withTimestamps()
                    ->withPivot(['principal', 'ativo', 'id'])
                    ->where('perfil_id', $perfilId)->first();
    }

    public function unidades()
    {
        return $this->perfis->where('pivot.ativo', 1)->pluck('unidade')->unique();
    }

    public function unidade()
    {
        return $this->perfis->where('pivot.ativo', 1)->pluck('unidade')->first();
    }

    /**
     * Retorna os perfis do usuário na unidade informada
     *
     * @param $unidadeId
     * @param $ativo
     *
     * @return collect
     */
    public function perfisUnidade($unidadeId = null, $ativo = null)
    {
        $perfis = collect($this->perfis);
        if (!is_null($unidadeId)) {
            $perfis = $perfis->where('unidade_id', $unidadeId);
        }

        if (!is_null($ativo)) {
            $perfis = $perfis->where('pivot.ativo', $ativo);
        }

        return $perfis;
    }
}
