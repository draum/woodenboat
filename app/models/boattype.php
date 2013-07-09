<?php

namespace WBDB\Model;

Class BoatType extends Base
{

    protected $table='boat_type';
    
    public function fetchAll() {
        $stmt = $this->_pdo->prepare("SELECT * FROM boat_type");                                    
        $stmt->execute();                        
        $boat_types = $stmt->fetchAll(\PDO::FETCH_CLASS);                                                                                       
        return $boat_types;        
    }

    public function boat()
    {
        return $this->hasMany('Boat');
    }
}