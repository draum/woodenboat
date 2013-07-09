<?php

namespace WBDB\Model;

use \stdClass, \Exception;

/**
 * Designer model
 * 
 *  @package WBDB   
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class Designer extends Base 
{

    protected $table = 'designer';
    
    /** Eloquent ORM methods for table joins -- we aren't using these, but I want them for later expansion. **/
    public function boat()
    {
        return $this->hasMany('Boat');
    }

}
