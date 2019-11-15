<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplayCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replay_comment', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('text');
            $table->bigInteger('comment_id')->unsigned();
            $table->timestamps();

            $table->foreign('comment_id')->references('id')->on('comments')
                ->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replay_comment');
    }
}
