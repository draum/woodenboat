<?php

namespace WBDB\Model;

use \stdClass, \Exception;

/**
 * Designer model
 * 
 *  @package WBDB   
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class Designer extends Base implements Repository
{

    protected $table = 'designer';
    
    /** 
     * Create a new designer
     * 
     * @param stdClass $designer
     * @return stdClass $designer A new designer
     * @throws Exception If unable to create the new entity
     */
    public function add(StdClass $designer)
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
    public function change($id, stdClass $data)
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
    public function appendBoats(stdClass $designer)
    {
        $boat = \App::make('WBDB\Model\Boat');
        $designer->boats = $boat->fetchByDesignerID($designer->id);
        return $designer;

    }

    /** Eloquent ORM methods for table joins -- we aren't using these, but I want them for later expansion. **/
    public function boat()
    {
        return $this->hasMany('Boat');
    }

}
