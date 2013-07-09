<?php

namespace WBDB\Model;

use \stdClass, \Exception;

use WBDB\QueryPagination;

/**
 * Boat model
 * 
 * @package WBDB   
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class Boat extends Base 
{
    protected $table = 'boat';
    private $textSearch = null;
    private $currentPage = null;

    /** Eloquent ORM methods for table joins -- we aren't using these, but I want them for later expansion. **/
    public function constructionType()
    {
        $this->has_many_and_belongs_to('ConstructionType');
    }

    public function boatattributes()
    {
        return $this->hasMany('BoatAttributes');
    }

    public function craft()
    {
        return $this->belongsToMany('Craft');
    }

    public function designer()
    {
        return $this->belongsTo('Designer');
    }

    public function boatType()
    {
        return $this->belongsTo('BoatType');
    }

}
