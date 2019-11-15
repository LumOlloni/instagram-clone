<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('bio');
            $table->integer('image_id')->unsigned();

            $table->boolean('is_public');

            $table->timestamps();

            $table->foreign('id')->references('id')->on('users')
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
        Schema::dropIfExists('profiles');
    }
}
