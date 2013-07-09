<?php

class BoatTableSeeder extends Seeder {

    public function run()
    {
        DB::table('boat')->delete();
                 
        $sailboat_type = DB::table('boat_type')->select('id')
                                        ->where('name', 'sailboat')
                                        ->first()
                                        ->id;
        
        
        $welsford_id = DB::table('designer')->select('id')
                                        ->where('company_name', 'John Welsford Small Craft Design')
                                        ->first()
                                        ->id;
                                                
        
        $oughtred_id = DB::table('designer')->select('id')
                                        ->where('company_name', 'Iain Oughtred Designs')
                                        ->first()
                                        ->id;
                
        $boats = array(
            array(
                'name'              => 'Walkabout',                
                'short_description' => 'Cruising Dinghy for the Maine Island trail',
                'long_description'  => '',                
                'type_id'           => $sailboat_type,
                'designer_id'       => $welsford_id,
                'created_at'      => new DateTime,
                'updated_at'      => new DateTime,                                
            ),
            array(            
                'name'              => 'Pathfinder',                
                'short_description' => '17ft gaff rigged yawl',
                'long_description'  => '',
                'type_id'           => $sailboat_type,
                'designer_id'       => $welsford_id,
                'created_at'      => new DateTime,
                'updated_at'      => new DateTime,                                
            ),
            array(            
                'name'              => 'Caledonia Yawl',                
                'short_description' => 'Double-ended Beachboat',
                'long_description'  => '',
                'type_id'           => $sailboat_type,
                'designer_id'       => $oughtred_id,
                'created_at'      => new DateTime,
                'updated_at'      => new DateTime,                                
            )
        );

        DB::table('boat')->insert( $boats);
    }

}
