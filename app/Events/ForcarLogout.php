<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ForcarLogout implements ShouldBroadcast
{

    /**
     * @var string|null
     */
    public $slugId;

    public function __construct($slugId = null)
    {
        $this->slugId = $slugId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        $channels = [
            new Channel('sessao')
        ];

        if (!is_null($this->slugId)) {
            $channels[] = new PrivateChannel('sessao.' . $this->slugId);
        }

        return $channels;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'sessao.forcar_logout';
    }
}
