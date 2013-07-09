<?php

use Illuminate\Database\Migrations\Migration;

class CreateConstructionTypeBoatTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('construction_type_boat', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('boat_id')->unsigned();
            $table->integer('constructiontype_id')->unsigned();
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
        Schema::drop('construction_type_boat');
    }
}