<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LikeEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $post_id;

    public $action;

    public function __construct( $post_id, $action )
    {

        $this -> post_id  = $post_id;

        $this -> action  = $action;

        $this -> dontBroadcastToCurrentUser();

    }

    /**
     * Get the channels the event should broadcast on.
     *[[[[[[[
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        //echo  $this -> post_id; exit;

        return new Channel( 'like.' . $this -> post_id );
    }
}
