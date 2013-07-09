<?php

namespace WBDB\Repository;

Class ConstructionTypeRepository extends BaseRepository
{

    public function fetchAll() {        
        $stmt = $this->_pdo->prepare("SELECT * FROM construction_type");                                    
        $stmt->execute();                        
        $construction_types = $stmt->fetchAll(\PDO::FETCH_CLASS);                                                                                       
        return $construction_types;
    }

}