<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('image_id')->unsigned();
            $table->string('description');
            $table->bigInteger('user_id')->unsigned();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onCascade('delete');

            // $table->foreign('image_id')->references('id')->on('images')
            //     ->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_posts');
    }
}
