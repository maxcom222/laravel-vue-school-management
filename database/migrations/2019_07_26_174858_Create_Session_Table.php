<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sessions', function (Blueprint $table) {
            $table  -> increments('id');
            $table  -> unsignedBigInteger('user1_id');
            $table  -> unsignedBigInteger('user2_id');
            $table  -> unique(['user1_id', 'user2_id']);
            $table  -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
