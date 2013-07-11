<?php

use WBDB\Repository\BoatRepository;
use WBDB\Model\BoatModel;

class BoatRepositoryTest extends TestCase {
    // Test using the non-Eloquent finders
    public function testFetchAllBoats() {
        $boatRepository = new BoatRepository;
        $results = $boatRepository->fetchAll();
        $this->assertTrue(is_array($results));
    }
    
    public function testFetchOneBoat() {
        $boatRepository = new BoatRepository;
        $boat = $boatRepository->fetch(1);        
        $this->assertTrue(is_object($boat));
    }
    
    public function testFetchBoatsByDesigner() {
        $boatRepository = new BoatRepository;
        $designer_boats = $boatRepository->fetchByDesignerID(1);
        
        $this->assertTrue(is_array($designer_boats));
    }
    
    public function testTextSearch() {
        $boatRepository = new BoatRepository;
        $boats = $boatRepository->textSearch("yawl")->fetchAll();        
        // There should be two matches based on the seeded data
        $this->assertEquals(count($boats)-2, 2, "Should receive 2 search results for yawl.");
    }
    
    public function testTextSearchNoResults() {
        $boatRepository = new BoatRepository;
        $boats = $boatRepository->textSearch("ooga booga")->fetchAll();                
        $this->assertFalse($boats,"Should not receive search results.");
    }
    
     // Test using the non-Eloquent add function
    public function testAddNewBoat() {
        $boat = new BoatModel;
        $boat->name = "This Doesn't Exist";
        $boat->designer_id = 1;
        $boat->type_id = 1;    
        $boatRepository = new BoatRepository;
        $new_boat = $boatRepository->add($boat);
        $this->assertTrue(is_object($new_boat));               
    }
    
    public function testAddNewBoatAppendAttributes() {
        $boat = new BoatModel;
        $boat->name = "No Exist";
        $boat->designer_id = 1;
        $boat->type_id = 1;
        $boat->short_description = "This is a short description.";
        $boat->long_description = "This is a long description";        
        $boat->user_id = 1;
        $attr = array("LOA" => array(
                        "value" => "10",
                        "unit"  => "FT"));
        
        $boat->attributes = $attr;        
        $boatRepository = new BoatRepository;        
        $new_boat = $boatRepository->add($boat);
       
        
        $this->assertTrue($new_boat->LOA->value == "10" && $new_boat->LOA->unit == "FT");
    }
    
    public function testAddNewBoatAppendConstructionTypes() {
        $boat = new BoatModel;
        $boat->name = "Even Less Existant";
        $boat->designer_id = 1;
        $boat->type_id = 1;
        $boat->short_description = "This is a short description.";
        $boat->long_description = "This is a long description";        
        $boat->user_id = 1;
        $construction_types = array(1,2);
       
        $boat->construction_types = $construction_types; 
        $boatRepository = new BoatRepository;        
        $new_boat = $boatRepository->add($boat);
    	    
    	    $this->assertTrue(in_array("cold molded", $new_boat->friendly_construction_types));
    	    
    }
   

    public function testRemoveBoat() {

        $boat = new BoatModel;
        $boat->name = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15);
        $boat->designer_id = 1;
        $boat->type_id = 1;
        $boatRepository = new BoatRepository;

        $new_boat = $boatRepository->add($boat);

        $this->assertTrue(is_object($new_boat), "Unable to create object in the delete test.");

        $id = $new_boat->id;

        unset($new_boat);
        $boatRepository->remove($id);

        $retry_new_boat = $boatRepository->fetch($id);
        $this->assertFalse(is_object($retry_new_boat), "Unable to remove a boat.");

    }

		public function testChangeBoat() {
        $boatRepository = new BoatRepository;
        $boat = $boatRepository->fetch(1);
        
        $old_long_description = $boat->long_description;
        $boat->long_description = "This is the new long description.";
        $boatRepository->change($boat->id,$boat);
        
        unset($boat);
        
        $boat = $boatRepository->fetch(1);
        $this->assertFalse($boat->long_description == $old_long_description);
     } 
        
        			
}
