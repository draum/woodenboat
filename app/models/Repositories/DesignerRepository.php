<?php

namespace WBDB\Repository;

use \stdClass, \Exception, \App;

// Use IoC to ensure all the required models are available
\App::bind('\WBDB\Repository\BoatRepository', 'DesignerRepository');

/**
 * Designer repository model
 * 
 * @package WBDB   
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class DesignerRepository extends BaseRepository 
{
    protected $boatRepository = null;
    
    /**
     * IoC binds some dependancies via constructor
     * 
     * @param BoatRepository $boatRepository
     * @return
     */
    public function __construct(\WBDB\Repository\BoatRepository $boatRepository)
    {
        parent::__construct();
        $this->boatRepository = $boatRepository;
    }
    
    /** 
     * Create a new designer
     * 
     * @param stdClass $designer
     * @return stdClass $designer A new designer
     * @throws Exception If unable to create the new entity
     */
    public function add($designer)
    {
        $this->_pdo->beginTransaction();
        try {


            $stmt = $this->_pdo->prepare("INSERT INTO designer 
                                         (first_name,last_name,company_name,email_address,
                                         address1,address2,city,state,
                                         zip,country,phone1,phone2,
                                         url1,url2,notes,user_id,
                                         created_at, updated_at)
                                         VALUES
                                         (?, ?, ?, ?,
                                          ?, ?, ?, ?,
                                          ?, ?, ?, ?,                                          
                                          ?, ?, ?, ?,
                                          now(), now())");

            $stmt->execute(array(
                $designer->first_name,
                $designer->last_name,
                $designer->company_name,
                $designer->email_address,
                $designer->address1,
                $designer->address2,
                $designer->city,
                $designer->state,
                $designer->zip,
                $designer->country,
                $designer->phone1,
                $designer->phone2,
                $designer->url1,
                $designer->url2,
                $designer->notes,
                $designer->user_id));

            $designer_id = $this->_pdo->lastInsertId();
            $this->_pdo->commit();
        }
        catch (Exception $e) {
            $this->_pdo->rollback();
            throw new Exception("Unable to add new designer. " . $e->getCode());
        }
        return $this->fetch($designer_id);
    }

    /**
     * Update a designer 
     * 
     * @param int $id
     * @param stdClass $data     
     */
    public function change($id, $data)
    {
        throw exception ("Not yet implemented.");
    }

    /**
     * Delete a designer
     * 
     * @param integer $id
     * @return boolean
     * @throws Exception If unable to delete the entity
     */
    public function remove($id)
    {
        $this->_pdo->beginTransaction();
        try {
            $stmt = $this->_pdo->prepare("DELETE FROM designer WHERE id = ?");
            $stmt->execute(array($id));
            $this->_pdo->commit();
        }
        catch (Exception $e) {
            $this->_pdo->rollback();
            throw new Exception("You must remove this designer's boats manually before removing the designer. " . $e->getCode());
        }
        return true;
    }

    /**
     * Retrieve a designer
     * 
     * @param int $id
     * @return stdClass $designerResult
     * @throws Exception If unable to retrieve a row
     */
    public function fetch($id)
    {
        $stmt = $this->_pdo->prepare("SELECT designer.*                                                                                         
                                      FROM designer
                                      WHERE designer.id = :designer_id");
        $stmt->bindParam(':designer_id', $id);
        $stmt->execute();
        $designerResult = $stmt->fetchObject();
        $designerResult = $this->appendBoats($designerResult);
        return $designerResult;
    }
    
    /**
     * Retrieve all designers
     * 
     * @return array Array of stdClass designer objects
     * @throws Exception If unable to retrieve rows
     */
    public function fetchAll()
    {
        $stmt = $this->_pdo->prepare("SELECT designer.*                                                                                         
                                      FROM designer");
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_CLASS);
        return $results;
    }
    
    /**
     * Kludgey way to merge the boats into the designer object
     * @param stdClass $designer
     * @return stdClass $designer
     */ 
    private function appendBoats(stdClass $designer)
    {        
        $designer->boats = $this->boatRepository->fetchByDesignerID($designer->id);
        return $designer;

    }
}