<?php

namespace App\Models;

class Session extends BaseModel
{
    protected $table = 'sessions';

    public $timestamps = false;

    protected $casts = [
        'bloqueada' => 'boolean',
    ];

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
        'bloqueada',
    ];
}
