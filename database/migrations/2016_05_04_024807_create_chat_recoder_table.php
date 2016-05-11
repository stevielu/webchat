<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatRecoderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_recoder', function (Blueprint $table) {
            $table->increments('channel_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->string('channel');
            $table->string('contents');
            $table->foreign('room_id')->references('id')->on('chat_room')->onDelete('CASCADE')->onUpdate('CASCADE');
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
       Schema::drop('chat_recoder');
    }
}
