<?php

namespace App\Listeners;

use App\Events\UserStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserStatusListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserStatus  $event
     * @return void
     */
    public function handle(UserStatus $event)
    {
        p( $event );
    }
}
