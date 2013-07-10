<?php

class WbdbForeignKeys
{
    /**
    * Make changes to the database.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('boat', function($table)
        {
            $table->foreign('designer_id')->references('id')->on('designer');
            $table->foreign('type_id')->references('id')->on('boat_type');
            $table->foreign('user_id')->references('id')->on('users');
        });
        

        Schema::table('boat_attributes', function($table)
        {
            $table->foreign('boat_id')->references('id')->on('boat');
        });
        
        Schema::table('builder', function($table)
        {
            $table->foreign('user_id')->references('id')->on('users');
        });                    

        Schema::table('craft', function($table)
        {
            $table->foreign('boat_id')->references('id')->on('boat');
            $table->foreign('builder_id')->references('id')->on('builder');
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::table('designer', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('craft_attributes', function($table)
        {
            $table->foreign('craft_id')->references('id')->on('craft');            
        });

    }

    /**
    * Revert the changes to the database.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('boat', function($table)
        {
            $table->dropForeign('boat_designer_id_foreign');
            $table->dropForeign('boat_boat_type_id_foreign');            
        });

        Schema::table('boat_attributes', function($table)
        {
            $table->dropForeign('boat_attributes_boat_id_foreign');
        });
                

        Schema::table('craft', function($table)
        {
            $table->dropForeign('craft_boat_id_foreign');
            $table->dropForeign('craft_builder_id_foreign');
        });

        Schema::table('craft_attributes', function($table)
        {
            $table->dropForeign('craft_attributes_craft_id_foreign');
        });

    }
}