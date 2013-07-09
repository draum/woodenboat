<?php

namespace WBDB\Controller;

use \Input, \User, \Validator, \Auth, \Request, \View, \stdClass, \Redirect;

// Use IoC to ensure all the required models are available
\App::bind('\WBDB\Repository\BoatRepository', 'Boat');
\App::bind('\WBDB\Repository\DesignerRepository', 'Boat');
\App::bind('\WBDB\Model\ConstructionType', 'Boat');
\App::bind('\WBDB\Model\BoatType', 'Boat');
\App::bind('\WBDB\UnitConverter', 'Boat');

/**
 * Boat controller
 * 
 * @package WBDB   
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class Boat extends \AuthorizedController
{

    protected $boatRepository = null;
    protected $construction_type = null;
    protected $boat_type = null;
    protected $designerRepository = null;
    protected $uc = null;

    // White list guest-accessible actions (do not require account login)
    protected $whitelist = array(
        'getIndex',
        'getBoat',
        'postSearch');

    /**
     * IoC binds some dependancies via constructor
     * 
     * @param BoatRepository $boatRepository
     * @param ConstructionType $construction_type
     * @param BoatType $boat_type
     * @param DesignerRepository $designerRepository
     * @param UnitConverter $unit_converter
     * @return
     */
    public function __construct(\WBDB\Repository\BoatRepository $boatRepository, \WBDB\Model\ConstructionType
        $construction_type, \WBDB\Model\BoatType $boat_type, \WBDB\Repository\DesignerRepository $designerRepository, \WBDB\UnitConverter
        $unit_converter)
    {
        parent::__construct();

        // Because we're not using most of Eloquent's functionality, we need to
        // pass in a model instance that we can use even if we aren't using it as an AR instance
        // Chicken chicken chicken, chicken chicken
        $this->boatRepository = $boatRepository;
        $this->construction_type = $construction_type;
        $this->boat_type = $boat_type;
        $this->designerRepository = $designerRepository;
        $this->uc = $unit_converter;
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    /**
     * Main boat display page.
     *     
     * @return   \View
     */
    public function getIndex()
    {
        try {
            if (Input::get('page')) {
                $page = Input::get('page');
            } else {
                $page = 1;
            }            
            $boats = $this->boatRepository->page($page)->fetchAll();
        }
        catch (exception $e) {
            return Redirect::to('/boat')->withErrors("Unable to retrieve boats." . $e->
                getMessage());
        }
        return View::make('boat/index')->with('boats', $boats)->with('uc', $this->uc);
    }


    /**
     * GET action to display a boat, split into Ajax (modal) and normal views
     * 
     * @param mixed $id
     * @return
     */
    public function getBoat($id)
    {
        try {
            $boat = $this->boatRepository->fetch($id);
        }
        catch (exception $e) {
            return Redirect::to('/boat')->withErrors("Unable to retrieve boat." . $e->
                getMessage());
        }

        if (Request::ajax()) {            
            return View::make('boat/ajax_show')->with('boat', $boat)->with('uc', $this->uc);
        } else {
            return View::make('boat/show')->with('boat', $boat)->with('uc', $this->uc);
        }
    }


    /**
     * Boat::addBoat()
     * 
     * @return
     */
    public function addBoat()
    {
        if (Request::ajax()) {
            $construction_types = $this->construction_type->fetchAll();
            $boat_types = $this->boat_type->fetchAll();
            $designers = $this->designerRepository->fetchAll();
            return View::make('boat/ajax_add')->with('construction_types', $construction_types)->
                with('boat_types', $boat_types)->with('designers', $designers);
        } else {
            return Redirect::to('/boat');
        }
    }


    /**
     * Boat::deleteBoat()
     * 
     * @param mixed $id
     * @return
     */
    public function deleteBoat($id)
    {
        try {
            $boat = $this->boatRepository->fetch($id);
        }
        catch (exception $e) {
            return Redirect::to('/boat')->withErrors("Unable to retrieve boat for deletion." .
                $e->getMessage());
        }

        if ($boat->user_id <> Auth::user()->id) {
            return Redirect::to('/boat')->withErrors("You do not have permission to delete that boat.");
        }

        if (Request::ajax()) {
            return View::make('boat/ajax_delete')->with('boat', $boat);
        } else {
            return Redirect::to('/boat')->withErrors("You cannot delete a boat that way.");
        }
    }


    /**
     * POST action for adding a boat
     */
    public function postAdd()
    {
        $input = Input::all();
        $rules = array(
            'name' => 'required|min:3|unique:boat,name',
            'boat_type' => 'required|integer',
            'designer' => 'required|integer',
            'url1'     => 'url',
            'url2'     => 'url',
            'thumbnail_pic' => 'url');

        $messages = array('boat_type.integer' => 'You must select a watercraft type.',
                'designer.integer' => 'You must select a designer.');

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::to('/boat')->withErrors($validator->messages()->all());
        }

        // Again, we're deliberately avoiding using the Eloquent ORM methods.
        $boat = new stdClass;
        $boat->name = Input::get('name');
        $boat->short_description = Input::get('short_description');
        $boat->type_id = Input::get('boat_type');
        $boat->designer_id = Input::get('designer');
        $boat->long_description = Input::get('long_description');
        $boat->construction_types = Input::get('construction_types');
        $boat->user_id = Auth::user()->id;

        $attr = array();
        if (Input::get('loa_value')) {
            $attr["LOA"] = array("value" => Input::get('loa_value'), "unit" => Input::get('loa_unit'));
        }
        if (Input::get('thumbnail_pic')) {
            $attr['thumbnail_pic'] = array("value" => Input::get('thumbnail_pic'), "unit" =>
                    "");
        }
        if (Input::get('url1')) {
            $attr['url1'] = array("value" => Input::get('url1'), "unit" =>
                    "");
        }        
        if (Input::get('url2')) {
            $attr['url2'] = array("value" => Input::get('url2'), "unit" =>
                    "");
        }
        if (Input::get('beam_value')) {
            $attr["beam"] = array("value" => Input::get('beam_value'), "unit" => Input::get
                    ('beam_unit'));
        }
        if (Input::get('dry_weight_value')) {
            $attr["dry_weight"] = array("value" => Input::get('dry_weight_value'), "unit" =>
                    Input::get('dry_weight_unit'));
        }
        if (Input::get('sail_area_value')) {
            $attr["sail_area"] = array("value" => Input::get('sail_area_value'), "unit" =>
                    Input::get('sail_area_unit'));
        }
        $boat->attributes = $attr;
        try {
            $this->boatRepository->add($boat);
            return Redirect::to('/boat')->with("success", "$boat->name added successfully.");
        }
        catch (exception $e) {
            return Redirect::to('/boat')->withErrors("Unable to add new boat. " . $e->
                getMessage());
        }
    }

    /**
     * POST action for removing a boat
     * 
     * @param integer $id
     */
    public function postDelete($id)
    {
        try {
            $boat = $this->boatRepository->fetch($id);
        }
        catch (exception $e) {
            return Redirect::to('/boat')->withErrors("Unable to retrieve boat for deletion." .
                $e->getMessage());
        }

        if (!$boat) {
            return Redirect::to('/boat')->withErrors("You do not have permission to delete that boat.");
        }

        if ($boat->user_id <> Auth::user()->id) {
            return Redirect::to('/boat')->withErrors("You do not have permission to delete that boat.");
        }

        try {
            $this->boatRepository->remove($id);
            return Redirect::to('/boat')->with("success", "$boat->name successfully deleted.");
        }
        catch (exception $e) {
            return Redirect::to('/boat')->withErrors("Unable to delete that boat. " . $e->
                getMessage());
        }
    }


    /**
     * Search form posting action
     * 
     * @return \View
     */
    public function postSearch()
    {        
        if (Input::get('searchText')) {        
            $search = Input::get('searchText');                   
        } else {
            $search = "";
        }
        
        if (Input::get('page')) {
            $page = Input::get('page');
        } else {
            $page = 1;
        }
                      
        $boats = $this->boatRepository->textSearch($search)->page($page)->fetchAll();
        $searchCount = count($boats)-2;
        return View::make('boat/index')->with('boats', $boats)->with('uc', $this->uc)->with("searchQuery", Input::get('searchText'))->with("searchCount", $searchCount);
        
                
    }
}
