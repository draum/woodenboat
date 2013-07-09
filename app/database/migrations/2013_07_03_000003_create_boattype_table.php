<?php

use Illuminate\Database\Migrations\Migration;

class CreateBoatTypeTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('boat_type', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 120)->nullable()->default(NULL);
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
        Schema::drop('boat_type');
    }
}