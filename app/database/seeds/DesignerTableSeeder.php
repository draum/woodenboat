<?php

class DesignerTableSeeder extends Seeder {

    public function run()
    {
        DB::table('designer')->delete();


        $designer1 = array(
            array(
                'first_name'      => 'John',
                'last_name'       => 'Welsford',
                'email_address'   => 'jwboatdesigns@xtra.co.nz',
                'url1'            => 'http://www.jwboatdesigns.co.nz/',
                'company_name'    => 'John Welsford Small Craft Design',
                'address1'        => 'PO Box 24 062',
                'city'            => 'Hamilton',
                'country'         => 'NZ',
                'created_at'      => new DateTime,
                'updated_at'      => new DateTime,
                
            )
        );
        $designer2 = array(
            array(
                'first_name'      => 'Iain',
                'last_name'       => 'Oughtred',
                'email_address'   => 'n/a',
                'url1'            => 'http://jordanboats.co.uk/JB/iain_oughtred.htm',
                'url2'            => 'http://www.classicmarine.co.uk/boatsearch.asp',
                'company_name'    => 'Iain Oughtred Designs',
                'address1'        => 'Struan Cottage',
                'address2'        => 'Bernisdale',
                'city'            => 'Isle of Skye',
                'country'         => 'GB',
                'zip'             => 'IV51 9NS',
                'phone1'          => '+44 1470 532732',
                'created_at'      => new DateTime,
                'updated_at'      => new DateTime,
            )
        );
                
        DB::table('designer')->insert( $designer1 );
        
        DB::table('designer')->insert( $designer2 );
    }

}
