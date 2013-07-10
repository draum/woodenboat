<?php

namespace WBDB\Model;

Class BoatAttributeModel extends BaseModel {

    protected $table = 'boat_attributes';
    protected static $rules = array();

    public function boat() {
        return $this->belongsTo('Boat');
    }

}
