<?php

namespace WBDB\Model;

Class CraftAttributeModel extends BaseModel {

    protected $table = 'craft_attributes';
    protected static $rules = array();
    public function craft() {
        return $this->belongsTo('Craft');
    }

}
