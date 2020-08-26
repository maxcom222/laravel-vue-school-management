<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot( )
    {


        Broadcast::routes(['middleware' => 'force_auth_user']);


        Broadcast::channel('userStatusChannel.{id}', function ($user, $id) {

            return true;

        });



        Broadcast::channel('user.*', function ($user) {

            return true;
        });




        Broadcast::routes(['middleware' => 'force_auth_user']);

        require base_path('routes/channels.php');
    }
}
