<?php

namespace WBDB;

interface MergerInterface {
    
    public function merge();
    
    public function with($element);
}
