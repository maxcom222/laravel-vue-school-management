<?php

namespace App\Http\Resources;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Http\Request;



class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request )
    {
        ///return parent::toArray($request);

        return [

            'id' => $this->id,

            'name' => $this->name,

            'email' => $this->email,

            'profile_photo' => $this->profile_photo,

            'username' => $this -> username,

            'online' => false,

            'session' => $this -> session_detail( $this -> id, $request   ),


        ];


    }

    public function  session_detail( $id, $request  )
    {

        if (! $request->session()->has('user'))
        {
            $result = json_encode( (object) null );

            $respone_to_app['status'] 	= '200';

            $respone_to_app['message']  = 'success';

            $respone_to_app['data'] 	=  'session is expired';

            $respone_to_app['result'] 	=  '2';

            return response()->json( $respone_to_app );
        }

        $user		 = $request->session()->get('user');

        $uid 	 	 = $user -> id;

        $session_id =   Session::whereIn('user1_id', [$uid, $id])
                            ->  whereIn('user2_id', [$uid, $id]) -> first();

        return new SessionResource( $session_id );

    }
}
