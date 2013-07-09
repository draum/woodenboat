<?php

namespace WBDB\Model;

use \stdClass;

use WBDB\QueryPagination;

/**
 * Boat model
 * 
 * @package WBDB   
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class Boat extends Base implements PseudoORM
{
    protected $table = 'boat';
    private $textSearch = null;
    private $currentPage = null;

    /**
     * Create a new boat
     * 
     * @param stdClass $boat
     * @return stdClass $boat A shiny new boat object
     * @throws Exception If unable to create the new entity
     */
    public function add(stdClass $boat)
    {
        $this->_pdo->beginTransaction();
        try {
            $stmt = $this->_pdo->prepare("INSERT INTO boat (name,short_description,type_id,designer_id,long_description, user_id,created_at,updated_at) VALUES (?, ?, ?, ?, ?, ?,now(),now())");
            $stmt->execute(array(
                $boat->name,
                $boat->short_description,
                $boat->type_id,
                $boat->designer_id,
                $boat->long_description,
                $boat->user_id));

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
                    $aSql .= " ($boat_id, \"$attr\", \"" . addslashes($attr_data["value"]) . "\", \"${attr_data["unit"]}\", now(), now()),";
                }                
                $aSql = preg_replace('/,$/', '', $aSql);
                $stmt = $this->_pdo->prepare($aSql);
                $stmt->execute();
            }

            $this->_pdo->commit();
        }
        catch (exception $e) {
            $this->_pdo->rollback();
            throw new Exception("Unable to add new boat. " . $e->getCode());
        }
        return $this->fetch($boat_id);
    }

    /**
     * Update a boat 
     * 
     * @param int $id
     * @param stdClass $data     
     */
    public function change($id, stdClass $data)
    {
        throw exception ("Not yet implemented.");
    }

    /**
     * Delete a boat
     * 
     * @param integer $id
     * @return boolean
     * @throws Exception If unable to delete the entity
     */
    public function remove($id)
    {
        $this->_pdo->beginTransaction();
        try {
            $stmt = $this->_pdo->prepare("DELETE FROM boat_attributes WHERE boat_id = ?");
            $stmt->execute(array($id));

            $stmt = $this->_pdo->prepare("DELETE FROM construction_type_boat WHERE boat_id = ?");
            $stmt->execute(array($id));

            $stmt = $this->_pdo->prepare("DELETE FROM boat WHERE id = ?");
            $stmt->execute(array($id));
            $this->_pdo->commit();
        }
        catch (exception $e) {
            $this->_pdo->rollback();
            throw new Exception("Unable to delete. " . $e->getCode());
        }
        return true;
    }


    /**
     * Retrieve a boat
     * 
     * @param int $id
     * @return stdClass $boatResult
     * @throws Exception If unable to retrieve a row
     */
    public function fetch($id)
    {
        try {
            $stmt = $this->_pdo->prepare("SELECT boat.*,                                            
                                             concat(designer.first_name,' ',designer.last_name) as designer_name,                                             
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
        }
        catch (exception $e) {
            throw new Exception("Unable to retrieve boat from the database. " . $e->getCode
                ());
        }
        if (!$boatResult) {
            return false;
        }
        $boatResult = $this->appendAttributes($boatResult);
        $boatResult = $this->appendConstructionTypes($boatResult);
        $boatResult->photos = null;
        return $boatResult;

    }


    /**
     * Retrieve all boats
     * 
     * @return array Array of stdClass boat objects
     * @throws Exception If unable to retrieve rows
     */
    public function fetchAll()
    {
        $fetchAllSql = "SELECT boat.*,concat(designer.first_name,' ',designer.last_name) as designer_name,                                             
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
                             (concat(designer.first_name,' ',designer.last_name) LIKE :search1)
                                OR
                             (designer.company_name LIKE :search2)
                                OR 
                             (boat.name LIKE :search3)
                                OR 
                             (boat.short_description LIKE :search4)
                                OR
                             (boat.long_description LIKE :search5)";
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
            }
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS);
        }
        catch (exception $e) {
            throw new Exception("Unable to retrieve boats from the database. " . $e->
                getCode());
        }
        $resultCollection = array();
        foreach ($results as $boat) {
            $boat = $this->appendAttributes($boat);
            $boat = $this->appendConstructionTypes($boat);
            $boat->photos = null;
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
     * @return array Array of stdClass boat objects
     * @throws Exception If unable to retrieve rows
     */
    public function fetchByDesignerID($designer_id)
    {
        try {
            $stmt = $this->_pdo->prepare("SELECT boat.*,                                            
                                             concat(designer.first_name,' ',designer.last_name) as designer_name,                                             
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
        }
        catch (exception $e) {
            throw new Exception("Unable to retrieve boats from the database, using designer ID criteria. " .
                $e->getCode());
        }
        $resultCollection = array();
        foreach ($results as $boat) {
            $boat = $this->appendAttributes($boat);
            $boat = $this->appendConstructionTypes($boat);
            $boat->photos = null;
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
    public function textSearch($searchTerm)
    {
        $this->textSearch = $searchTerm;
        return $this;
    }

    /**
     * Fluent method to add pagination
     */
    public function page($currentPage)
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    /**
     * Append boat attributes (many-to-many) to the boat object
     * This is a bit kludgey, but I'm avoiding using the Eloquent native methods for this
     * 
     * @param stdClass $boat
     * @return stdClass $boat
     * @throws Exception If unable to retrieve rows
     */
    private function appendAttributes(stdClass $boat)
    {
        try {
            $stmt = $this->_pdo->prepare("SELECT attribute,value,unit FROM boat_attributes WHERE boat_id = :boat_id");
            $stmt->bindParam(':boat_id', $boat->id);
            $stmt->execute();
            $boat_attrs = $stmt->fetchAll(\PDO::FETCH_CLASS);
        }
        catch (exception $e) {
            throw new Exception("Unable to retrieve attributes for this boat." . $e->
                getCode());
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
     * @return stdClass $boat
     * @throws Exception If unable to retrieve rows
     */
    private function appendConstructionTypes(stdClass $boat)
    {
        try {
            $stmt = $this->_pdo->prepare("SELECT construction_type.id,name,description 
                                        FROM construction_type 
                                            JOIN construction_type_boat 
                                                ON construction_type.id = construction_type_boat.constructiontype_id
                                        WHERE construction_type_boat.boat_id = :boat_id");
            $stmt->bindParam(':boat_id', $boat->id);
            $stmt->execute();
            $boat->construction_types = $stmt->fetchAll(\PDO::FETCH_CLASS);
        }
        catch (exception $e) {
            throw new Exception("Unable to retrieve constructon types for this boat." . $e->
                getCode());
        }
        return $boat;
    }


    /** Eloquent ORM methods for table joins -- we aren't using these, but I want them for later expansion. **/
    public function constructionType()
    {
        $this->has_many_and_belongs_to('ConstructionType');
    }

    public function boatattributes()
    {
        return $this->hasMany('BoatAttributes');
    }

    public function craft()
    {
        return $this->belongsToMany('Craft');
    }

    public function designer()
    {
        return $this->belongsTo('Designer');
    }

    public function boatType()
    {
        return $this->belongsTo('BoatType');
    }

}
