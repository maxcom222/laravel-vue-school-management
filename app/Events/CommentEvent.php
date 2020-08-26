<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentEvent implements  ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $post_id;

    public $action;

    public $actor;

    public $comment_data ;

    public function __construct( $post_id,  $action,  $actor , $comment_data )
    {

        $this -> post_id       = $post_id;

        $this -> action        = $action;

        $this -> actor         = $actor;

        $this -> comment_data  = $comment_data ;

        $this -> dontBroadcastToCurrentUser();

    }

    /**
     * Get the channels the event should broadcast on.
     *[[[[[[[
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {


        return new Channel( 'comment.' . $this -> post_id );

    }

}
