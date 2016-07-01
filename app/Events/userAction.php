<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class userAction extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    private $username;
    private $userstatus;
    private $ch;

    public function __construct($username,$userstatus,$channel)
    {
        $this->username = $username;
        $this->userstatus = $userstatus;
        $this->ch = $channel;
    }

    public function broadcastWith()
    {
       
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
                break;
        }
        
    }
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [$this->ch];
    }
}
