<?php

class BoatAttributeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('boat_attributes')->delete();

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
                
        $boat_attrs = array(
            array(
                'attribute' => 'LOA',
                'value'     => '5.25',
                'unit'      => 'M',
                'boat_id'   => $pathfinder_id,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                
            ),
            array(
                'attribute' => 'beam',
                'value'     => '1.95',
                'unit'      => 'M',
                'boat_id'   => $pathfinder_id                                ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime 
            ),
            array(
                'attribute' => 'dry_weight',
                'value'     => '220',
                'unit'      => 'KGS',
                'boat_id'   => $pathfinder_id,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                 
            ),
            array(
                'attribute' => 'sail_area',
                'value'     => '15.1',
                'unit'      => 'SQM',
                'boat_id'   => $pathfinder_id,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                 
            ),
            array(
                'attribute' => 'url1',
                'value'     => 'http://www.jwboatdesigns.co.nz/plans/pathfinder/index.htm',
                'unit'      => '',                
                'boat_id'   => $pathfinder_id,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                 
            ),            
            array(
                'attribute' => 'LOA',
                'value'     => '5',
                'unit'      => 'M',
                'boat_id'   => $walkabout_id ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                
            ),
            array(
                'attribute' => 'beam',
                'value'     => '5',
                'unit'      => 'FT',
                'boat_id'   => $walkabout_id,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                 
            ),
            array(
                'attribute' => 'dry_weight',
                'value'     => '200',
                'unit'      => 'LBS',
                'boat_id'   => $walkabout_id ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                
            ),
            array(
                'attribute' => 'sail_area',
                'value'     => '80',
                'unit'      => 'SQFT',
                'boat_id'   => $walkabout_id ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                
            ),
            array(
                'attribute' => 'plans_cost',
                'value'     => '295',
                'unit'      => 'NZD',
                'boat_id'   => $walkabout_id ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                
            ),
            array(
                'attribute' => 'study_plans',
                'value'     => '30',
                'unit'      => 'USD',
                'boat_id'   => $walkabout_id ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                
            ),
            array(
                'attribute' => 'url1',
                'value'     => 'http://www.jwboatdesigns.co.nz/plans/walkabout/index.htm',
                'unit'      => '',                
                'boat_id'   => $walkabout_id ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                
            ),
            array(
                'attribute' => 'LOA',
                'value'     => '5.95',
                'unit'      => 'M',
                'boat_id'   => $cy_id        ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                         
            ),
            array(
                'attribute' => 'beam',
                'value'     => '1.88',
                'unit'      => 'FT',
                'boat_id'   => $cy_id        ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                         
            ),
            array(
                'attribute' => 'dry_weight',
                'value'     => '340',
                'unit'      => 'LBS',
                'boat_id'   => $cy_id        ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                         
            ),
            array(
                'attribute' => 'sail_area',
                'value'     => '164',
                'unit'      => 'SQFT',
                'boat_id'   => $cy_id        ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                         
            ),
            array(
                'attribute' => 'plans_cost',
                'value'     => '130',
                'unit'      => 'GBP',
                'boat_id'   => $cy_id        ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                         
            ),
            array(
                'attribute' => 'url1',
                'value'     => 'http://jordanboats.co.uk/JB/IainO_Catalogue/Caledonia%20Yawl.pdf',
                'unit'      => 'PDF',                
                'boat_id'   => $cy_id        ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                         
            ),
            array(
                'attribute' => 'thumbnail_pic',
                'value'     => 'http://www.duckworksmagazine.com/10/splash/july/4397769.jpg',
                'unit'      => '',                
                'boat_id'   => $walkabout_id ,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                
            ),
            array(
                'attribute' => 'thumbnail_pic',
                'value'     => 'http://www.fyneboatkits.co.uk/photos/products/welsford-pathfinder/fast-comfortable-cruising-dinghy-welsford-pathfinder.jpg',
                'unit'      => '',                
                'boat_id'   => $pathfinder_id,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                 
            ),
            array(
                'attribute' => 'thumbnail_pic',
                'value'     => 'http://www.bodaciousboats.com/Xena2722sm.jpg',
                'unit'      => '',                
                'boat_id'   => $cy_id,
                'created_at' => new DateTime,
                'updated_at' => new DateTime                                 
            ),            
            
        );

        DB::table('boat_attributes')->insert( $boat_attrs);
    }

}
