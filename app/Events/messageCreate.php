<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class messageCreate extends Event implements ShouldBroadcast
{
    use SerializesModels;

    private $username;

    private $message;

    private $ch;

    private $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($username, $message,$channel,$user)
    {
        $this->username = $username;
        $this->message= $message;
        $this->ch = $channel;
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $attrbuite['avatar'] = $this->user['my_avatar'];
        return [
            'username' => $this->username,
            'message' => $this->message,
            'userAttribute' => $attrbuite,
        ];
    }
    
    public function broadcastOn()
    {
        return [$this->ch];
    }
}
