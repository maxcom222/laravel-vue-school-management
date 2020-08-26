<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_chats', function (Blueprint $table) {

            $table->increments('id');

            $table -> unsignedInteger('message_id');

            $table -> unsignedInteger('session_id');

            $table -> unsignedInteger('user_id');

            $table  -> dateTime('read_at') -> nullable();

            $table -> boolean('type'); //   0 for ssend and 1 for receive



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_chats');
    }
}
