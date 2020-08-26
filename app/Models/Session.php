<?php

namespace App\Models;

use App\Events\BlockEvent;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    //
    protected $table = 'tbl_sessions';
    protected  $guarded = [];
    public  function chats()
    {

      return $this -> hasManyThrough(Chat:: class, ChatMessage:: class);

      /*
       *
       * one session can have multiple chat and chat messages
       *
       */

    }
    public function messages()
    {
        return $this -> hasMany( ChatMessage::class);

    }

    public function clearMessages(  $uid )
    {

         $this  -> chats()  -> where('user_id','=', $uid  )  -> delete();

    }

    public  function deleteMessages(   $uid )
    {
         $this  -> messages() -> delete();
    }

    public function  block( $uid )
    {

        $this -> block  = true;

        $this -> blocked_by = $uid;

        $this -> save();


    }

    public function  unblock( $uid )
    {

        $this -> block  = false;

        $this -> blocked_by = null;

        $this -> save();

    }

}
