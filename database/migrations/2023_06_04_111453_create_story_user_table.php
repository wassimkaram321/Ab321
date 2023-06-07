<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryUserTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('story_user')) {
            Schema::create('story_user', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('story_id');
                $table->unsignedBigInteger('user_id');
                $table->timestamps();

                $table->foreign('story_id')->references('id')->on('stories')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('story_user');
    }
}
