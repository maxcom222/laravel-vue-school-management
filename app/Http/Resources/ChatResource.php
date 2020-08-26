<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
        $read_at =  $this  -> read_at ;

        if( is_null( $this  -> read_at )  ===  FALSE  )
        {
            if( $this -> type == 0 )
            {
                $read_at =  Carbon::parse($this  -> read_at) -> diffForHumans();
            }
            else
            {
                $read_at = null;
            }

        }
        return [

            'message' => $this -> message['content'],

            'attachment' => $this -> message['attachment'],

            'type' => $this -> type,

            'id'  => $this  -> id,

            'send_at' => $this ->  created_at -> diffForHumans(),

            'read_at' => $read_at,

            'created_at' => $this  -> created_at,


        ];

    }

    private function read_at_timing( $_this )
    {

        if( $_this -> type == 0  )
        {
            return $_this -> read_at ;
        }
        else {

            return null;
        }
    }
}
