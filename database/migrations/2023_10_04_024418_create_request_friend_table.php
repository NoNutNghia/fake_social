<?php

use App\Enum\RequestStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestFriendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_friend', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('target_id');
            $table->tinyInteger('request_type');
            $table->tinyInteger('request_status')->default(RequestStatusEnum::USER_PENDING);
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
        Schema::dropIfExists('request_friend');
    }
}
