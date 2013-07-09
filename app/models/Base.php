<?php

namespace WBDB\Model;

Class Base extends \Eloquent {    
    protected $_pdo = null;
    
    public function __construct() {        
        $this->_pdo = \DB::connection()->getPdo();            
    }
}
