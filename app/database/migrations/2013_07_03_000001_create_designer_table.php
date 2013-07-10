<?php

use Illuminate\Database\Migrations\Migration;

class CreateDesignerTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('designer', function($table)
        {
            $table->engine='InnoDB';
            $table->increments('id')->unsigned();
            $table->string('first_name', 45)->nullable()->default(NULL);
            $table->string('last_name', 45)->nullable()->default(NULL);
            $table->string('company_name', 120)->nullable()->default(NULL);
            $table->string('address1', 120)->nullable()->default(NULL);
            $table->string('address2', 120)->nullable()->default(NULL);
            $table->string('city', 45)->nullable()->default(NULL);
            $table->string('state', 45)->nullable()->default(NULL);
            $table->string('zip', 45)->nullable()->default(NULL);
            $table->string('country', 2)->nullable()->default(NULL);
            $table->string('email_address', 80)->nullable()->default(NULL);
            $table->string('url1', 120)->nullable()->default(NULL);
            $table->string('url2', 120)->nullable()->default(NULL);
            $table->string('phone1', 80)->nullable()->default(NULL);
            $table->string('phone2', 80)->nullable()->default(NULL);
            $table->text('notes')->nullable()->default(NULL);
            $table->string('misc', 255)->nullable()->default(NULL);
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
        Schema::drop('designer');
    }
}