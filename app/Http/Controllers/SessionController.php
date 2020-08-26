<?php

namespace App\Http\Controllers;

use App\Events\SessionEvent;

use App\Http\Resources\SessionResource;

use App\Http\Resources\UserResource;
use App\Models\Session;

use App\Models\User;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    //
    public function  create (Request $request )
    {
        $friend_id   = $request ->  friend_id;

        $user		 = $request->session()->get('user');

        $uid 	 	 = $user -> id;

        $arr = ['user1_id' =>  $uid,  'user2_id' => $friend_id, 'block' =>0 , 'blocked_by' => null ];


        $session  = Session::create( $arr );

        //$user_data =  $this -> UserResource( $user );

        $user_data =  UserResource::collection(  User::where( 'id',  $uid  )  -> get() );

        $modifiedSession = new SessionResource( $session);

        broadcast(  new SessionEvent( $modifiedSession, $uid, $user_data  ));

        return  $modifiedSession;

    }

    private function UserResource( $user )
    {
        $userResource = [];

        $userResource['first_name'] = $user ->  first_name;

        $userResource['last_name'] = $user ->  last_name;

        $userResource['profile_photo'] = $user ->  profile_photo;

        $userResource['id'] =    $user ->  id;

        $userResource['email'] =    $user ->  email;

        return  $userResource;
    }
}
