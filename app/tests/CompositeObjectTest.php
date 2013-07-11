<?php

class CompositeObjectTest extends TestCase {

    public function testInstantiation()
    {
        $co = new WBDB\CompositeObject;        
        $this->assertInstanceOf('WBDB\CompositeObject', $co, "Composite object is not of the proper type.");               
    }
    
    public function testSingleObjectComposite() {
        $testObject = new stdClass;
        $testObject->foo = "bar";
        
        $co = new WBDB\CompositeObject;
        $co->merge($testObject);
        
        $this->assertEquals($co->foo,"bar", "Single object composite did not return the expected value.");
    }
    
    
    public function testTwoObjectComposite() {
        $testObjectOne = new stdClass;
        $testObjectOne->foo = "bar";
        
        $testObjectTwo = new StdClass;
        $testObjectTwo->bar = "foo";
        
        $co = new WBDB\CompositeObject;
        $co->merge($testObjectOne,$testObjectTwo);
        
        $this->assertEquals($co->foo,"bar","Double object composite (object one) is not returning the right value.");
        $this->assertEquals($co->bar,"foo","Double object composite (object two) is not returning the right value.");
        
    }
    
    public function testTwoObjectCompositeWithConflictingValues() {
        $testObjectOne = new stdClass;
        $testObjectOne->foo = "thisone";
        
        $testObjectTwo = new StdClass;
        $testObjectTwo->foo = "notthis";
        
        $co = new WBDB\CompositeObject;
        $co->merge($testObjectOne,$testObjectTwo);
        
        $this->assertEquals($co->foo,"thisone","Double object composite is not returning the expected value on a conflicting object merge.");
        
        
    }
    
    public function testCompositeObjectArrayStorage() {
        $testObjectOne = new stdClass;
        $testObjectOne->foo = array("ooo"=>array(1,2,3));
        
        $testObjectTwo = new stdClass;
        $testObjectTwo->foo = "notthis";
        
        $co = new WBDB\CompositeObject;
        $co->merge($testObjectOne,$testObjectTwo);
        
        $this->assertArrayHasKey("ooo", $co->foo, "Array stored in composite object did not merge properly.");
        
    }
    
    public function testThreeObjectComposite() {
        $testObjectOne = new stdClass;
        $testObjectOne->foo = "one";
                
        $testObjectTwo = new stdClass;
        $testObjectTwo->bar = "two";
        
        $testObjectThree = new stdClass;
        $testObjectThree->baz = "three";
        
        $co = new WBDB\CompositeObject;
        $co->merge($testObjectOne,$testObjectTwo,$testObjectThree);
        
        $this->assertEquals($co->foo,"one");
        $this->assertEquals($co->bar,"two");
        $this->assertEquals($co->baz,"three");               
    }
    
    public function testNestedObjectComposite() {
        $testObjectOne = new stdClass;
        $testObjectOne->foo = new stdClass;
        $testObjectOne->foo->bar = "baz";
        
        $co = new WBDB\CompositeObject;
        $co->merge($testObjectOne);
        
        $this->assertEquals($co->foo->bar,"baz","Nested object value did not merge properly.");
        $this->assertInstanceOf('stdClass', $co->foo, "Merged composite object is not of the proper type.");       
        
        
    }

}