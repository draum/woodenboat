<?php

namespace WBDB\Models;

Class Craft extends BaseModel {

    protected $table = 'craft';
    protected static $rules = array();
    public function craftattributes() {
        return $this->hasMany('CraftAttributes');
    }

    public function boat() {
        return $this->belongsTo('Boat');
    }

    public function builder() {
        return $this->belongsTo('Builder');
    }

}
