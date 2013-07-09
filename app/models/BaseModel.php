<?php

namespace WBDB\Model;

use \Eloquent, \DB;

Class BaseModel extends Eloquent {    
    protected $_pdo = null;
    
    public function __construct() {        
        $this->_pdo = DB::connection()->getPdo();            
    }
}
