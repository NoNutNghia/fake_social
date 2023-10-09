<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePushNotiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_noti', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->boolean('noti_request');
            $table->boolean('noti_post_by_myself');
            $table->boolean('noti_comment');
            $table->boolean('noti_react_post');
            $table->boolean('noti_react_comment');
            $table->boolean('noti_post_by_friend');
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
        Schema::dropIfExists('push_noti');
    }
}
