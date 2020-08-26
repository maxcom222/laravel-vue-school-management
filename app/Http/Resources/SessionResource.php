<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // return parent::toArray($request);

        $user		 = $request->session()->get('user');

        $uid 	 	 = $user -> id;


        return [

            'id' => $this -> id,

            'users'  => [ $this -> user1_id, $this  -> user2_id ],

            'open' => false,

            'unreadCount' => $this -> chats ->  where ('read_at', null)

                            -> where('type', '0')

                            -> where('user_id', '<>',  $uid  ) -> count(),

            'block'  => $this  -> block,

            'blocked_by' => $this -> blocked_by,

        ];

    }
}
