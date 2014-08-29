<?php

namespace WBDB\Repositories;

use App;
use DB;
use Exception;

/**
 * Extendable repository
 *
 * @package WBDB
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class BaseRepository implements Repository
{
    protected $_pdo = null;

    public function __construct()
    {
        $this->_pdo = DB::connection()->getPdo();
    }

    public function add($newEntity)
    {
        throw new Exception("Not yet implemented.");
    }

    public function remove($id)
    {
        throw new Exception("Not yet implemented.");
    }

    public function change($id, $data)
    {
        throw new Exception("Not yet implemented.");
    }

    public function fetch($id)
    {
        throw new Exception("Not yet implemented.");
    }

    public function fetchAll()
    {
        throw new Exception("Not yet implemented.");
    }

}


