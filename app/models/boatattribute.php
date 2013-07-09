<?php

namespace WBDB\Model;

Class BoatAttributeModel extends BaseModel
{

    protected $table='boat_attributes';
    
    public function boat()
    {
        return $this->belongsTo('Boat');
    }

}