<?php

namespace WBDB\Model;

Class Builder extends Base
{

    protected $table='builder';

    public function craft()
    {
        return $this->belongsToMany('Craft');
    }
    
    public function user()
    {
        return $this->belongsTo('User');
    }
}