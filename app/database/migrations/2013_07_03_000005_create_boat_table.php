<?php

use Illuminate\Database\Migrations\Migration;

class CreateBoatTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('boat', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 80)->nullable()->default(NULL);
            $table->string('short_description', 255)->nullable()->default(NULL);            
            $table->text('long_description')->nullable()->default(NULL);            
            $table->integer('designer_id')->unsigned()->nullable()->default(NULL);
            $table->integer('type_id')->unsigned()->nullable()->default(NULL);
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
        Schema::drop('boat');
    }
}