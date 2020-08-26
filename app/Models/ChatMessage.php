<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    //

    protected  $guarded = [];
    protected $table = 'tbl_chat_message';
    public function chat()
    {

        return $this ->  hasMany( Chat::class, '');
    }

    public function  createForSend( $session_id, $uid  )
    {

       return  $this -> Chat() -> create([

            'session_id'  => $session_id,
            'type' =>  0,
            'user_id'=> $uid,

        ]);

    }
    public function  createForReceive( $session_id, $to_user  )
    {

        return $this -> Chat() -> create([

            'session_id'  => $session_id,
            'type' =>  1,
            'user_id'=> $to_user,

        ]);

    }


}
