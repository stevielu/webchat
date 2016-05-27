<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChannelOperation extends Event implements ShouldBroadcast
{
    use SerializesModels;

    private $name;
    private $data;
    private $command;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data,$command)
    {
        $this->data = $data;
        $this->command = $command;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastWith()
    {
        switch ($this->command) {
            case 'create':
                return [
                    'channelname' => $this->data['channelName'],
                    'command' => $this->command,
                    'result' => 'Done',
                ];
                break;
            
            default:
                # code...
                break;
        }

       
    }
    
    public function broadcastOn()
    {
        return ['controller-channel'];
    }
}
