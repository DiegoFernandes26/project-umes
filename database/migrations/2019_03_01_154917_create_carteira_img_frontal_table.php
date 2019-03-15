<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarteiraImgFrontalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carteira_img_frontals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('img_frontal')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('carteira_img_frontals');
    }
}
