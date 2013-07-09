<?php

class ConstructionTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('construction_type')->delete();


        $construction_types = array(
            array(
                'name'      => 'plywood'                                
            ),
            array(
                'name'      => 'glued clinker plywood'                                
            ),
            array(
                'name'      => 'cold molded'                                
            ),
            array(
                'name'      => 'strip planked'                                
            ),
            array(
                'name'      => 'traditional plank'                                
            ),
            array(
                'name'      => 'stich and glue plywood'                                
            ),
            array(
                'name'      => 'stich and tape plywood'                                
            ),
            array(
                'name'      => 'lapstrake on bent frames'                                
            ),
            array(
                'name'      => 'other'                                
            )            
        );

        DB::table('construction_type')->insert( $construction_types );
    }

}
