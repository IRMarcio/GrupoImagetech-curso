<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Login'   => [
            'App\Events\UsuarioEventHandler@onLogin',
        ],
        'Illuminate\Auth\Events\Logout'  => [
            'App\Events\UsuarioEventHandler@onLogout',
        ],
        'Illuminate\Auth\Events\Failed'  => [
            'App\Events\UsuarioEventHandler@onLoginFail',
        ],
        'Illuminate\Auth\Events\Lockout' => [
            'App\Events\UsuarioEventHandler@onLockout',
        ],
        'Illuminate\Mail\Events\MessageSending' => [
            'App\Events\EnviandoEmailHandler@onMessageSending',
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'App\Events\AuditoriaEventHandler'
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
