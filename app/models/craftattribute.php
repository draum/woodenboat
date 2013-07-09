<?php

namespace WBDB\Model;

Class CraftAttributeModel extends BaseModel
{

    protected $table='craft_attributes';

    public function craft()
    {
        return $this->belongsTo('Craft');
    }

}