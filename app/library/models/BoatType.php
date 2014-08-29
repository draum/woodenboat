<?php

namespace WBDB\Models;

Class BoatTypeModel extends BaseModel {

    protected $table = 'boat_type';
    protected static $rules = array();
    public function boat() {
        return $this->hasMany('Boat');
    }

}
