<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShirtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shirts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            // Owner of shirt
            $table->integer('user_id');
            $table->string('size');
            $table->string('photo')->nullable();
            // Color model
            $table->integer('color_id');
            // Scale 1-10
            $table->integer('comfortability');
            $table->integer('wear');
            // In cm
            $table->integer('sleeve_length');
            // Miscellaneous notes
            $table->string('notes');
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
        Schema::drop('shirts');
    }
}
