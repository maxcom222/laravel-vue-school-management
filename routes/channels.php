<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {


    return (int) $user->id === (int) $id;
});






Broadcast::channel('userStatusChannel.{id}', function ($user, $id) {


    return true;

});

Broadcast::channel('online', function ($user  ) {
    return ['name' => $user->name,  'id' => $user -> id ];

});


Broadcast::channel('PrivateChat.{id}', function ($user, $id) {
    return true;
});


Broadcast::channel('Chat.{id}', function ($user, $userId) {
    return true;
});

Broadcast::channel('ChatJ', function () {

    return ['uid' =>  '5025', 'name' => 'bilal'];
});