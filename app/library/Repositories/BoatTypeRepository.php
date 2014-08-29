<?php

namespace WBDB\Repositories;

Class BoatTypeRepository extends BaseRepository
{

    public function fetchAll() {
        $stmt = $this->_pdo->prepare("SELECT * FROM boat_type");                                    
        $stmt->execute();                        
        $boat_types = $stmt->fetchAll(\PDO::FETCH_CLASS);                                                                                       
        return $boat_types;        
    }
}
