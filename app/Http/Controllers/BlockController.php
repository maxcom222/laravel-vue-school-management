<?php

namespace App\Http\Controllers;

use App\Events\BlockEvent;
use App\Models\Session;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function block( Session $session ,Request $request )
    {

        $user		 = $request->session()->get('user');

        $uid 	 	 = $user -> id;

        $session -> block( $uid );

        broadcast(new  BlockEvent( $session -> id, true ));


        return  response(null, 201);

    }

    public function unblock( Session $session ,Request $request )
    {

        $user		 = $request->session()->get('user');

        $uid 	 	 = $user -> id;

        $session -> unblock( $uid );

        broadcast(new  BlockEvent( $session -> id, false ));


        return  response(null, 201);

    }


}
