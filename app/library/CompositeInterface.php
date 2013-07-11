<?php

namespace WBDB;

interface CompositeInterface {
    
    public function merge();
    
    public function with($element);
}
