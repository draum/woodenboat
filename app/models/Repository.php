<?php

namespace WBDB\Repository;

use \stdClass;

/**
 * Repository interface
 * 
 * @package WBDB   
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
interface Repository {

    /**
     * Add functionality, requires a stdClass object -- ensuring we don't accidentally have an Eloquent one
     * 
     * @param stdClass $newEntity
     * @return stdClass Newly created entity
     */
    public function add(stdClass $newEntity);

    /**
     * remove()
     * 
     * @param Integer $id
     * @return boolean
     */
    public function remove($id);

    /**
     * change()
     * 
     * @param Integer $id
     * @param array $data
     * @return stdClass
     */
    public function change($id, stdClass $data);

    /**
     * Retrieve an entity by primary key / ID
     * 
     * @param int $id
     * @return stdClass Single entity
     */
    public function fetch($id);

    /**
     * Retrieve all entities
     * 
     * @return array Iterable collection of result objects 
     */
    public function fetchAll();
}
