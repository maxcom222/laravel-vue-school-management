<?php

namespace App\Classes;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
class NewNotification implements ShouldBroadcast
{
    public $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function broadcastOn()
    {
        return ['notification-channel'];
    }
}
