<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //

    protected  $guarded = [];
    protected $table = 'tbl_chats';

    public function message()
    {

        return $this -> belongsTo(ChatMessage::class, 'chat_message_id');

    }
}
