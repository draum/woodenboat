<?php 

namespace WBDB;

class ObjectMerger extends \ArrayObject implements MergerInterface {

    protected $composite = array();
    
    /**
     * Merge multiple objects stored in an array
     *
     * @param object[]|object $objects array of objects to merge or a single object     
     */

    public function merge() {
        $objects = func_get_args();        
        foreach($objects as $object) $this->with($object);        
        unset($object);
        return $this;
    }

    /**
     * Used to add an object to the composition
     *
     * @param object $object an object to merge     
     */
    public function with($object) {
        if(is_object($object)) {
            array_push($this->composite, clone $object);
        }        
        return $this;
    }

    /**
     * Magic method __get, retrieves the pseudo merged object
     *
     * @param string $name name of the variable in the object
     * @return mixed returns a reference to the requested variable
     *
     */
    public function  __get($name) {
        $return = null;                       
        foreach($this->composite as $object) {                       
            if(isset($object->$name)) {                                               
                $return = $object->$name;                                
                break;
            }
        }        
        unset($object);
        return $return;
    }
}