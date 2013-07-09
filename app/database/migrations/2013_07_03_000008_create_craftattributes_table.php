<?php

use Illuminate\Database\Migrations\Migration;

class CreateCraftattributesTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('craft_attributes', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->string('attribute', 45)->nullable()->default(NULL);
            $table->string('value', 45)->nullable()->default(NULL);
            $table->string('unit', 45)->nullable()->default(NULL);
            $table->integer('craft_id')->unsigned()->nullable()->default(NULL);
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
        Schema::drop('craft_attributes');
    }
}