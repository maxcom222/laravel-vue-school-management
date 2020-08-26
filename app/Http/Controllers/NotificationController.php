<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Pusher\Pusher;

use App\Classes\NewNotification;

class NotificationController extends Controller
{
    public function getIndex()
    {
        return view('notification');
    }

    public function notify(Request $request)
    {
        $notifyText = e($request->input('notify_text'));
			
		$pusher = new Pusher('986125bf96d8cbb40052', 'ad02a1b661965a179069', '606079'  );
		

		$pusher->trigger('test-channel', 
                 'test-event', 
                 ['text' => 'this is a notification']);
				 
				 $result = $pusher->get_channels();
		p( $result );
		exit;
        // TODO: Get Pusher instance from service container

        // TODO: The notification event data should have a property named 'text'

        // TODO: On the 'notifications' channel trigger a 'new-notification' event
    }
}

