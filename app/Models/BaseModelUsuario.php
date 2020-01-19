<?php

namespace App\Models;

use App\Models\RegistroTemporario;
use App\Notifications\ResetarSenha;
use App\Traits\HasHashSlug;
use Carbon\Carbon;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class BaseModelUsuario extends Authenticatable implements JWTSubject
{

    use Notifiable, HasHashSlug, CanResetPassword, PivotEventTrait;

    protected static $minSlugLength = 15;

    protected $guarded = ['id'];

    protected $appends = ['slug_id'];

    /**
     * Gera um registro temporário na tabela do model autal e um registro temporário na tebela de registro_temporario
     *
     * @return Model
     * @throws \ReflectionException
     */
    public static function gerarTemporario()
    {
        $self = new static();

        // Gera registro temporário vazio na tabela do model atual
        $self->timestamps = false;
        $self->save();

        // Cria reg temp na tabela registro_temporario
        RegistroTemporario::create([
                                      'conteudo_id' => $self->id,
                                      'model'       => (new \ReflectionClass($self))->getName()
                                  ]);

        return $self;
    }

    /**
     * Retorna a data de atualização do registro formatada.
     *
     * @return string
     */
    public function getAtualizadoEmAttribute()
    {
        if (!$this->updated_at) {
            return null;
        }

        if ($this->updated_at instanceof Carbon) {
            return $this->updated_at->formatLocalized('%d/%b/%y');
        }


        return formatarData($this->updated_at);
    }

    /**
     * Escopo para filtrar somente os registros ativos.
     *
     * @param $q
     *
     * @return mixed
     */
    public function scopeAtivo($q)
    {
        return $q->where('ativo', true);
    }

    /**
     * Transforma registro temporário em registro permanente
     *
     * @param array $dados
     *
     * @return Model
     * @throws \ReflectionException
     */
    public function transformarPermanente($dados = [])
    {
        // Exclui reg temp da tabela registro_temporario
        RegistroTemporario::where('conteudo_id', $this->id)->where('model', (new \ReflectionClass($this))->getName())->delete();

        // Seta create_at deixando de ser registro temporário
        $this->setCreatedAt(date('Y-m-d H:i:s'));

        // Atualiza os dados
        return $this->update($dados);
    }

    /**
     * Retorna o slug.
     *
     * @return string
     */
    public function getSlugIdAttribute()
    {
        return $this->slug();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetarSenha($token));
    }

    /**
     * Get the notification routing information for the given driver.
     *
     * @param  string $driver
     *
     * @return mixed
     */
    public function routeNotificationFor($driver)
    {
        if (method_exists($this, $method = 'routeNotificationFor' . Str::studly($driver))) {
            return $this->{$method}();
        }

        switch ($driver) {
            case 'database':
                return $this->notifications();
            case 'mail':
                return $this->email;
            case 'nexmo':
                return $this->phone_number;
        }
    }
}
