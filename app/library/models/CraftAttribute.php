<?php

namespace WBDB\Models;

Class CraftAttribute extends BaseModel
{

    protected $table = 'craft_attributes';
    protected static $rules = array();

    public function craft()
    {
        return $this->belongsTo('Craft');
    }

}
