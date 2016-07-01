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

    private $userstatus;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($username, $message,$channel,$user,$userstatus)
    {
        $this->username = $username;
        $this->message= $message;
        $this->ch = $channel;
        $this->user = $user;
        $this->userstatus = $userstatus;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $attrbuite['avatar'] = $this->user['my_avatar'];

        switch ($this->userstatus) {
            case 'joinch':
                return [
                    'username' => $this->username,
                    'action' => 'joinch',
                ];
                break;
            case 'leavech':
                return [
                    'username' => $this->username,
                    'action' => 'leavech',
                ];
                break;
            
            default:
                return [
                    'username' => $this->username,
                    'message' => $this->message,
                    'userAttribute' => $attrbuite,
                ];
                break;
        }
        
    }
    
    public function broadcastOn()
    {
        return [$this->ch];
    }
}
