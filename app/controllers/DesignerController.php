<?php

namespace WBDB\Controller;

use \Input, \User, \Validator, \Auth, \Request, \View, \Integer, \stdClass, \Redirect, \Exception;

// Use IoC to ensure all the required models are available
\App::bind('\WBDB\Model\Designer', 'Designer');

/**
 * Designer controller
 * 
 * @package WBDB   
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class Designer extends \AuthorizedController
{

    protected $designer = null;

    // White list guest-accessible actions (do not require account login)
    protected $whitelist = array('getIndex', 'getDesigner');

    /**
     * IoC binds some dependancies via constructor
     * 
     * @param Designer $designer
     * @return
     */
    public function __construct(\WBDB\Model\Designer $designer)
    {
        parent::__construct();
        $this->designer = $designer;
    }

    /**
     * Main designer display page.
     *     
     * @return   \View
     */
    public function getIndex()
    {
        try {
            $designers = $this->designer->fetchAll();
        }
        catch (exception $e) {
            return Redirect::to('/designer')->withErrors("Unable to retrieve designers." . $e->
                getMessage());
        }
        return \View::make('designer/index')->with('designers', $designers);
    }

    /**
     * Designer::getDesigner()
     * 
     * @param mixed $id
     * @return
     */
    public function getDesigner($id)
    {
        try {
            $designer = $this->designer->fetch($id);
        }
        catch (exception $e) {
            return Redirect::to('/designer')->withErrors("Unable to retrieve designer." . $e->
                getMessage());
        }
        if (\Request::ajax()) {
            return \View::make('designer/ajax_show')->with('designer', $designer);
        } else {
            return \View::make('designer/show')->with('designer', $designer);
        }
    }

    /**
     * Designer::addDesigner()
     * 
     * @return
     */
    public function addDesigner()
    {
        if (\Request::ajax()) {
            return \View::make('designer/ajax_add');
        } else {
            return Redirect::to('/designer');
        }
    }

    /**
     * Designer::deleteDesigner()
     * 
     * @param mixed $id
     * @return
     */
    public function deleteDesigner($id)
    {
        try {
            $designer = $this->designer->fetch($id);
        }
        catch (exception $e) {
            return Redirect::to('/designer')->withErrors("Unable to retrieve designer for deletion." .
                $e->getMessage());
        }
        if ($designer->user_id <> Auth::user()->id) {
            return Redirect::to('/designer')->withErrors("You do not have permission to delete that designer.");
        }

        if (Request::ajax()) {
            return View::make('designer/ajax_delete')->with('designer', $designer);
        } else {
            return Redirect::to('/designer')->withErrors("You cannot delete a designer that way.");
        }
    }

    /**
     * POST action for adding a boat
     * 
     * @param integer $id
     */
    public function postAdd()
    {
        $input = Input::all();
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email_address' => 'email',
            'url1'     => 'url',
            'url2'     => 'url'
            );
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::to('/designer')->withErrors($validator->messages()->all());
        }

        // Again, we're deliberately avoiding using the Eloquent ORM methods.
        $designer = new stdClass;
        $designer->first_name = Input::get('first_name');
        $designer->last_name = Input::get('last_name');
        $designer->company_name = Input::get('company_name');
        $designer->email_address = Input::get('email_address');

        $designer->address1 = Input::get('address1');
        $designer->address2 = Input::get('address2');
        $designer->city = Input::get('city');
        $designer->state = Input::get('state');
        $designer->zip = Input::get('zip');
        $designer->country = Input::get('country');

        $designer->phone1 = Input::get('phone1');
        $designer->phone2 = Input::get('phone2');

        $designer->url1 = Input::get('url1');
        $designer->url2 = Input::get('url2');

        $designer->notes = Input::get('notes');

        $designer->user_id = Auth::user()->id;
        try {
            $this->designer->add($designer);
            return Redirect::to('/designer')->with("success", "Designer $designer->first_name $designer->last_name added successfully.");
        }
        catch (exception $e) {
            return Redirect::to('/designer')->withErrors("Unable to add designer." . $e->
                getMessage());
        }
    }


    /**
     * Designer::postDelete()
     * 
     * @param mixed $id
     * @return
     */
    public function postDelete($id)
    {
        try {
            $designer = $this->designer->fetch($id);
        }
        catch (Exception $e) {
            return Redirect::to('/designer')->withErrors("Unable to retrieve designer for deletion." .
                $e->getMessage());
        }


        if ($designer->user_id <> Auth::user()->id) {
            return Redirect::to('/designer')->withErrors("You do not have permission to delete that designer.");
        }

        try {
            $this->designer->remove($id);
            return Redirect::to('/designer')->with("success", "$designer->first_name $designer->last_name successfully deleted.");
        }
        catch (Exception $e) {
            return Redirect::to('/designer')->withErrors("Unable to delete. " .
                $e->getMessage());
        }
    }


}
