<?php

use WBDB\Model\BoatModel;

class BoatModelTest extends TestCase {
    

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
