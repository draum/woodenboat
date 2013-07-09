<?php

namespace WBDB\Model;

Class BoatAttribute extends Base
{

    protected $table='boat_attributes';
    
    public function boat()
    {
        return $this->belongsTo('Boat');
    }

}