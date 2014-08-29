<?php

namespace WBDB\Models;

/**
 * Designer model
 *
 *  @package WBDB
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class DesignerModel extends BaseModel {

    protected $table = 'designer';
    protected static $rules = array();

    /** Eloquent ORM methods for table joins -- we aren't using these, but I want
     * them for later expansion. **/
    public function boat() {
        return $this->hasMany('Boat');
    }

}
