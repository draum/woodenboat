<?php

use Illuminate\Database\Migrations\Migration;

class CreateCraftTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('craft', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 45)->nullable()->default(NULL);
            $table->integer('boat_id')->unsigned()->nullable()->default(NULL);
            $table->integer('builder_id')->unsigned()->nullable()->default(NULL);
            $table->integer('user_id')->unsigned()->nullable()->default(NULL);
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
        Schema::drop('craft');
    }
}