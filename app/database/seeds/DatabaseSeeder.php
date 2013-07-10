<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UsersTableSeeder');
                
        $this->call('DesignerTableSeeder');
        
        $this->call('BoatTypeTableSeeder');
        
        $this->call('ConstructionTypeTableSeeder');
                
        $this->call('BoatTableSeeder');
        
        $this->call('BoatAttributeTableSeeder');
        
        $this->call('BoatConstructionTypeSeeder');
        
                
	}

}
