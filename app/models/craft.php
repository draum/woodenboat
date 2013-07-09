<?php

namespace WBDB\Model;

Class CraftModel extends BaseModel
{

    protected $table='craft';

    public function craftattributes()
    {
        return $this->hasMany('CraftAttributes');
    }

    public function boat()
    {
        return $this->belongsTo('Boat');
    }

    public function builder()
    {
        return $this->belongsTo('Builder');
    }

}