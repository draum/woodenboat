<?php

namespace WBDB\Model;

Class CraftAttribute extends Base
{

    protected $table='craft_attributes';

    public function craft()
    {
        return $this->belongsTo('Craft');
    }

}