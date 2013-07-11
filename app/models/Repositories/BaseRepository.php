<?php

namespace WBDB\Repository;

use \stdClass, \Exception, \DB, \App;

/**
 * Extendable repository
 * 
 * @package WBDB   
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class BaseRepository implements Repository {
    protected $_pdo = null;
    
    public function __construct() {        
        $this->_pdo = DB::connection()->getPdo();            
    }
    
    public function add($newEntity) {
        throw new Exception("Not yet implemented.");
    }

    public function remove($id) {
        throw new Exception("Not yet implemented.");
    }

    public function change($id, $data) {
        throw new Exception("Not yet implemented.");
    }

    public function fetch($id) {
        throw new Exception("Not yet implemented.");
    }

    public function fetchAll() {
        throw new Exception("Not yet implemented.");
    }

}


