<?php

class BoatControllerTest extends TestCase {

    public function testIndex() {
        $response = $this->get('/boat');
        $this->assertViewHas('boats');
        
        $data = $response->original->getData();
        $boats = $data['boats'];        
        $this->assertGreaterThanOrEqual(5, count($boats), "Not enough boats returned to the view.");       
    }
    
    public function testShowBoat() {
        $response = $this->get('/boat/1');
        $this->assertViewHas('boat');
        
        $data = $response->original->getData();
        $boat = $data['boat'];        
        $this->assertInstanceOf('WBDB\CompositeObject', $boat, "Composite object is not of the proper type.");
    }
}
