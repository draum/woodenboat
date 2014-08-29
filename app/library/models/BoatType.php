<?php

namespace WBDB\Models;

Class BoatType extends BaseModel {

    protected $table = 'boat_type';
    protected static $rules = array();
    public function boat() {
        return $this->hasMany('Boat');
    }

}
