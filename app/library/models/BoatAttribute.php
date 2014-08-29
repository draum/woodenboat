<?php

namespace WBDB\Models;

Class BoatAttribute extends BaseModel
{

    protected $table = 'boat_attributes';
    protected static $rules = array();

    public function boat()
    {
        return $this->belongsTo('Boat');
    }

}
