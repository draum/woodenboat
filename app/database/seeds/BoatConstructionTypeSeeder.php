<?php

class BoatConstructionTypeSeeder extends Seeder {

    public function run()
    {
        DB::table('construction_type_boat')->delete();

        $pathfinder_id = DB::table('boat')
                                        ->select('id')
                                        ->where('name', 'Pathfinder')
                                        ->first()
                                        ->id;
                                        
        $walkabout_id = DB::table('boat')
                                        ->select('id')
                                        ->where('name', 'Walkabout')
                                        ->first()
                                        ->id;
                                        
        $cy_id = DB::table('boat')
                                        ->select('id')
                                        ->where('name', 'Caledonia Yawl')
                                        ->first()
                                        ->id;
                                        
        $glued_clinker_id = DB::table('construction_type')
                                        ->select('id')
                                        ->where('name', 'glued clinker plywood')
                                        ->first()
                                        ->id;
        
        $trad_plank_id = DB::table('construction_type')
                                        ->select('id')
                                        ->where('name', 'traditional plank')
                                        ->first()
                                        ->id;
                                                                                             
        
        $boat_construction_types = 
            array(
                array(
                    'boat_id'=> $cy_id,
                    'constructiontype_id' => $glued_clinker_id),
                array(
                    'boat_id'=> $cy_id,
                    'constructiontype_id' => $trad_plank_id),
                array(
                    'boat_id'=> $pathfinder_id,
                    'constructiontype_id' => $glued_clinker_id),
                array(
                    'boat_id'=> $walkabout_id,
                    'constructiontype_id' => $glued_clinker_id),    
              
        );
        

        DB::table('construction_type_boat')->insert( $boat_construction_types );
    }

}
