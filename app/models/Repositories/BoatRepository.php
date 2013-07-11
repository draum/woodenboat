<?php

namespace WBDB\Repository;

use \stdClass, \Exception, \DateTime;

use WBDB\QueryPagination;
use WBDB\CompositeObject;
use WBDB\Model\BoatModel;

/**
 * Boat repository model
 *
 * @package WBDB
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class BoatRepository extends BaseRepository {
    private $textSearch = null;
    private $currentPage = null;


    public function __construct() {
        parent::__construct();
        $dt = new DateTime;
        $this->now = $dt->getTimestamp();
    }
    /**
     * Create a new boat
     *
     * @param stdClass $boat
     * @return stdClass $boat A shiny new boat object
     * @throws Exception If unable to create the new entity
     */
    public function add($boat) {
        $this->_pdo->beginTransaction();
        try {            
            $stmt = $this->_pdo->prepare("INSERT INTO boat (name,short_description,type_id,designer_id,long_description, user_id,created_at,updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(array(
                $boat->name,
                $boat->short_description,
                $boat->type_id,
                $boat->designer_id,
                $boat->long_description,
                $boat->user_id,
                $this->now,
                $this->now
            ));

            $boat_id = $this->_pdo->lastInsertId();

            if (is_array($boat->construction_types) && count($boat->construction_types > 0)) {
                $ctSql = "INSERT INTO construction_type_boat (constructiontype_id, boat_id) VALUES ";
                foreach ($boat->construction_types as $ctype) {
                    $ctSql .= "($ctype, $boat_id),";
                }
                $ctSql = preg_replace('/,$/', '', $ctSql);
                $stmt = $this->_pdo->prepare($ctSql);
                $stmt->execute();
            }

            if (is_array($boat->attributes) && count($boat->attributes) > 0) {
                $aSql = "INSERT INTO boat_attributes (boat_id, attribute, value, unit, created_at, updated_at) VALUES ";
                foreach ($boat->attributes as $attr => $attr_data) {
                    $aSql .= " ($boat_id, \"$attr\", \"" . addslashes($attr_data["value"]) . "\", \"${attr_data["unit"]}\", \"" . $this->now . "\", \"" . $this->now . "\"),";
                }
                $aSql = preg_replace('/,$/', '', $aSql);                
                $stmt = $this->_pdo->prepare($aSql);
                $stmt->execute();
            }

            $this->_pdo->commit();
        } catch (Exception $e) {
            $this->_pdo->rollback();
            throw new Exception("Unable to add new boat. " . $e->getCode());
        }
        return $this->fetch($boat_id);
    }

    /**
     * Update a boat
     *
     * @param int $id
     * @param stdClass $boat
     */
    public function change($id, $boat) {
        $this->_pdo->beginTransaction();
        try {
            $stmt = $this->_pdo->prepare("DELETE FROM boat_attributes WHERE boat_id = ?");
            $stmt->execute(array($id));

            $stmt = $this->_pdo->prepare("DELETE FROM construction_type_boat WHERE boat_id = ?");
            $stmt->execute(array($id));
        } catch (Exception $e) {
            $this->_pdo->rollback();
            throw new Exception("Unable to delete old values. " . $e->getCode());
        }

        try {
            $stmt = $this->_pdo->prepare("UPDATE boat 
                                            SET name = ?,
                                                short_description = ?,
                                                type_id = ?,
                                                designer_id = ?,
                                                long_description = ?,
                                                updated_at = ?
                                                WHERE id = ?");
            $stmt->execute(array(
                $boat->name,
                $boat->short_description,
                $boat->type_id,
                $boat->designer_id,
                $boat->long_description,
                $this->now,
                $id
            ));
        } catch (Exception $e) {
            $this->_pdo->rollback();
            throw new Exception("Unable to update values. " . $e->getMessage());
        }

        try {
            if (isset($boat->construction_types) && is_array($boat->construction_types) && count($boat->construction_types > 0)) {
            		
                $ctSql = "INSERT INTO construction_type_boat (constructiontype_id, boat_id) VALUES ";
                foreach ($boat->construction_types as $ctype) {
                		
                    $ctSql .= "($ctype->id, $id),";
                }
                
                $ctSql = preg_replace('/,$/', '', $ctSql);
                $stmt = $this->_pdo->prepare($ctSql);
                $stmt->execute();
            }

            if (isset($boat->attributes) && is_array($boat->attributes) && count($boat->attributes) > 0) {
                $aSql = "INSERT INTO boat_attributes (boat_id, attribute, value, unit, created_at, updated_at) VALUES ";
                foreach ($boat->attributes as $attr => $attr_data) {
                    $aSql .= " ($id, \"$attr\", \"" . addslashes($attr_data["value"]) . "\", \"" . $attr_data["unit"] . "\", \"" . $this->now . "\", \"" . $this->now . "\"),";
                }
                $aSql = preg_replace('/,$/', '', $aSql);
                
                $stmt = $this->_pdo->prepare($aSql);
                $stmt->execute();
            }

            $this->_pdo->commit();
        } catch (Exception $e) {
            $this->_pdo->rollback();
            throw new Exception("Unable to edit boat. " . $e->getCode());
        }
    }

    /**
     * Delete a boat
     *
     * @param integer $id
     * @return boolean
     * @throws Exception If unable to delete the entity
     */
    public function remove($id) {
        $this->_pdo->beginTransaction();
        try {
            $stmt = $this->_pdo->prepare("DELETE FROM boat_attributes WHERE boat_id = ?");
            $stmt->execute(array($id));

            $stmt = $this->_pdo->prepare("DELETE FROM construction_type_boat WHERE boat_id = ?");
            $stmt->execute(array($id));

            $stmt = $this->_pdo->prepare("DELETE FROM boat WHERE id = ?");
            $stmt->execute(array($id));
            $this->_pdo->commit();
        } catch (exception $e) {
            $this->_pdo->rollback();
            throw new Exception("Unable to delete. " . $e->getCode());
        }
        return true;
    }

    /**
     * Retrieve a boat
     *
     * @param int $id
     * @return mixed $boatResult
     * @throws Exception If unable to retrieve a row
     */
    public function fetch($id) {
        try {
            $stmt = $this->_pdo->prepare("SELECT boat.*,                                            
                                             designer.first_name as designer_first_name,
                                             designer.last_name as designer_last_name,                                             
                                             designer.company_name as designer_company,                                             
                                             boat_type.name as boat_type
                                      FROM boat
                                        JOIN designer
                                            ON boat.designer_id=designer.id
                                        JOIN boat_type
                                            ON boat.type_id = boat_type.id
                                      WHERE boat.id = :boat_id");
            $stmt->bindParam(':boat_id', $id);
            $stmt->execute();

            $boatResult = $stmt->fetchObject();

            if (!$boatResult) {
                return false;
            }
                                                
        } catch (exception $e) {
            throw new Exception("Unable to retrieve boat from the database. " . $e->getCode());
        }
        if (!$boatResult) {
            return false;
        }        
        $boatResult = $this->appendAttributes($boatResult);
        $boatResult = $this->appendConstructionTypes($boatResult);
        $boatResult->photos = null;
        
        $boat = new CompositeObject();
        $boat->merge($boatResult, new BoatModel);                
        return $boat;

    }

    /**
     * Retrieve all boats
     *
     * @return array Array of stdClass boat objects
     * @throws Exception If unable to retrieve rows
     */
    public function fetchAll() {
        $fetchAllSql = "SELECT boat.*,
                               designer.first_name as designer_first_name,
                               designer.last_name as designer_last_name,                                             
                               designer.company_name as designer_company,
                               boat_type.name as boat_type
                        FROM boat 
                            JOIN designer
                                ON boat.designer_id=designer.id
                            JOIN boat_type 
                                ON boat.type_id = boat_type.id";
        // If we've tacked on some textual search requirements
        if ($this->textSearch) {
            $fetchAllSql .= " WHERE 
                             (designer.first_name LIKE :search1)
                                OR
                             (designer.last_name LIKE :search2)
                                OR
                             (designer.company_name LIKE :search3)
                                OR 
                             (boat.name LIKE :search4)
                                OR 
                             (boat.short_description LIKE :search5)
                                OR
                             (boat.long_description LIKE :search6)";
        }

        if (!isset($this->currentPage)) {
            $this->currentPage = 1;
        }
        $paginate = QueryPagination::paginate($this->_pdo, $fetchAllSql, $this->currentPage, 5);

        $fetchAllSql .= $paginate['query'];

        try {
            $stmt = $this->_pdo->prepare($fetchAllSql);
            if ($this->textSearch) {
                $searchTerm = "%" . $this->textSearch . "%";
                $stmt->bindParam(':search1', $searchTerm, \PDO::PARAM_STR);
                $stmt->bindParam(':search2', $searchTerm, \PDO::PARAM_STR);
                $stmt->bindParam(':search3', $searchTerm, \PDO::PARAM_STR);
                $stmt->bindParam(':search4', $searchTerm, \PDO::PARAM_STR);
                $stmt->bindParam(':search5', $searchTerm, \PDO::PARAM_STR);
                $stmt->bindParam(':search6', $searchTerm, \PDO::PARAM_STR);
            }
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS);
            if (!$results) {
                return false;
            }
        } catch (exception $e) {
            throw new Exception("Unable to retrieve boats from the database. " . $e->getCode());
        }
        $resultCollection = array();
        foreach ($results as $boatResult) {
            $boatResult = $this->appendAttributes($boatResult);
            $boatResult = $this->appendConstructionTypes($boatResult);
            $boatResult->photos = null;
            $boat = new CompositeObject();
            $boat->merge($boatResult, new BoatModel);
            $resultCollection[$boat->id] = $boat;
        }
        $resultCollection['currentpage'] = $paginate['currentpage'];
        $resultCollection['totalpages'] = $paginate['totalpages'];
        return $resultCollection;
    }

    /**
     * Fetch boats by designer ID
     *
     * @param mixed $designer_id
     * @return array Array of merged boat objects
     * @throws Exception If unable to retrieve rows
     */
    public function fetchByDesignerID($designer_id) {
        try {
            $stmt = $this->_pdo->prepare("SELECT boat.*,                                            
                                             designer.first_name as designer_first_name,
                                             designer.last_name as designer_last_name,                                             
                                             designer.company_name as designer_company,
                                             boat_type.name as boat_type
                                      FROM boat 
                                        JOIN designer
                                            ON boat.designer_id=designer.id
                                        JOIN boat_type 
                                            ON boat.type_id = boat_type.id
                                      WHERE boat.designer_id = :designer_id");
            $stmt->bindParam(':designer_id', $designer_id);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS);
            if (!$results) {
                return false;
            }
        } catch (exception $e) {
            throw new Exception("Unable to retrieve boats from the database, using designer ID criteria. " . $e->getCode());
        }
        $resultCollection = array();
        foreach ($results as $boatResult) {
            $boatResult = $this->appendAttributes($boatResult);
            $boatResult = $this->appendConstructionTypes($boatResult);
            $boatResult->photos = null;
            $boat = new CompositeObject();
            $boat->merge($boatResult, new BoatModel);
            $resultCollection[$boat->id] = $boat;
        }
        return $resultCollection;
    }

    /**
     * Fluent method to add textual search
     *
     * @param string $searchTerm
     * @return Boat
     */
    public function textSearch($searchTerm) {
        $this->textSearch = $searchTerm;
        return $this;
    }

    /**
     * Fluent method to add pagination
     */
    public function page($currentPage) {
        $this->currentPage = $currentPage;
        return $this;
    }

    /**
     * Append boat attributes (many-to-many) to the boat object
     * This is a bit kludgey, but I'm avoiding using the Eloquent native methods
     * for this
     *
     * @param mixed $boat
     * @return mixed $boat
     * @throws Exception If unable to retrieve rows
     */
    private function appendAttributes($boat) {
        try {
            $stmt = $this->_pdo->prepare("SELECT attribute,value,unit FROM boat_attributes WHERE boat_id = :boat_id");
            $stmt->bindParam(':boat_id', $boat->id);
            $stmt->execute();
            $boat_attrs = $stmt->fetchAll(\PDO::FETCH_CLASS);
            if (!$boat_attrs) {
                return $boat;
            }
        } catch (Exception $e) {
            throw new Exception("Unable to retrieve attributes for this boat." . $e->getCode());
        }

        foreach ($boat_attrs as $attr) {
            $boat->{$attr->attribute} = new StdClass;
            if (isset($attr->unit)) {
                $boat->{$attr->attribute}->unit = $attr->unit;
                $boat->{$attr->attribute}->value = $attr->value;
            } else {
                $boat->{$attr->attribute}->value = $attr->value;
                $boat->{$attr->attribute}->unit = null;
            }
        }
        return $boat;
    }

    /**
     * Append construction types
     *
     * @param mixed $boat
     * @return BoatModel $boat
     * @throws Exception If unable to retrieve rows
     */
    private function appendConstructionTypes($boat) {
        try {
            $stmt = $this->_pdo->prepare("SELECT construction_type.id,name,description 
                                        FROM construction_type 
                                            JOIN construction_type_boat 
                                                ON construction_type.id = construction_type_boat.constructiontype_id
                                        WHERE construction_type_boat.boat_id = :boat_id");
            $stmt->bindParam(':boat_id', $boat->id);
            $stmt->execute();
            $construction_types = $stmt->fetchAll(\PDO::FETCH_CLASS);
            if (!$construction_types) {
                return $boat;
            }
            $boat->construction_types = $construction_types;
            $boat->friendly_construction_types = array();
            foreach ($boat->construction_types as $ctype) {
                $boat->friendly_construction_types[$ctype->id] = $ctype->name;
            }
        } catch (Exception $e) {
            throw new Exception("Unable to retrieve constructon types for this boat." . $e->getCode());
        }
        return $boat;
    }

}
