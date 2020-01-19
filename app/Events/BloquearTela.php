<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BloquearTela implements ShouldBroadcast
{

    /**
     * @var String
     */
    public $slugId;

    public function __construct($slugId)
    {
        $this->slugId = $slugId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('sessao.' . $this->slugId);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'sessao.bloquear_tela';
    }
}
