<?php

namespace WBDB\Model;

use \Validator, \Input;

/**
 * Boat model
 * 
 * @package WBDB   
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class BoatModel extends BaseModel 
{
    protected $table = 'boat';
    private $textSearch = null;
    private $currentPage = null;
    public static $validation = null;                  
    protected static $rules = array(
            'name' => 'required|min:3|unique:boat,name',
            'boat_type' => 'required|integer',
            'designer' => 'required|integer',
            'url1'     => 'url',
            'url2'     => 'url',
            'thumbnail_pic' => 'url');
                    

    public static function is_valid( $input = null )
    {
        if( is_null( $input ) )
            $input = Input::all();
        static::$validation = Validator::make( $input, static::$rules );
        return static::$validation->passes();

    }
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
