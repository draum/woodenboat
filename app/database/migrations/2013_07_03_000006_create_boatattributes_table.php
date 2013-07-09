<?php

use Illuminate\Database\Migrations\Migration;

class CreateBoatattributesTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('boat_attributes', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->string('attribute', 80)->nullable()->default(NULL);
            $table->string('value', 255)->nullable()->default(NULL);
            $table->string('unit', 45)->nullable()->default(NULL);
            $table->integer('boat_id')->unsigned()->nullable()->default(NULL);
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
        Schema::drop('boat_attributes');
    }
}