<?php

use Illuminate\Database\Migrations\Migration;

class CreateConstructionTypeTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('construction_type', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 120)->nullable()->default(NULL);
            $table->text('description');
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
        Schema::drop('construction_type');
    }
}