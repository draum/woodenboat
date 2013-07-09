<?php

namespace WBDB\Model;

Class BoatTypeModel extends BaseModel
{

    protected $table='boat_type';
       
    public function boat()
    {
        return $this->hasMany('Boat');
    }
}