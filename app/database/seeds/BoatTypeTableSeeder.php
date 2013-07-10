<?php

class BoatTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('boat_type')->delete();


        $boat_types = array(
            array(
                'name'      => 'sailboat'                                
            ),
            array(
                'name'      => 'motorboat'                                
            ),
            array(
                'name'      => 'kayak'                                
            ),
            array(
                'name'      => 'paddleboard'                                
            ),
            array(
                'name'      => 'canoe'                                
            ),
            array(
                'name'      => 'sailing canoe'                                
            ),
            array(
                'name'      => 'motorsailer'                                
            ),
            array(
                'name'      => 'other'                                
            )            
        );

        DB::table('boat_type')->insert( $boat_types );
    }

}
