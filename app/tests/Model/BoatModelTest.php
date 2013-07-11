<?php

use WBDB\Model\BoatModel;

class BoatModelTest extends TestCase {
    
    // Testing some model functionality -- we use the Eloquent ORM to populate the database, since 
    // those methods have good test coverage already.  Testing for the model repository CRUD methods
    // is in the model repository test suite.
    public function testIsInvalidWithoutAName()
    {
        $boat = new BoatModel;
        $this->assertFalse($boat->validate());
    }
    
    public function testIsInvalidWithoutUniqueName() {
        $boat = new BoatModel;
        $boat->name = "Pathfinder";
        $boat->save();
 
        $boat = new BoatModel;
        $boat->name = "Pathfinder";
        $this->assertFalse($boat->validate(), 'Expected validation to fail.');        
    }
       
}
