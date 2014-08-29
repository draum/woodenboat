<?php

namespace WBDB\Controllers;

use Auth;
use Input;
use Redirect;
use Request;
use Validator;
use View;

/**
 * BaseController
 *
 * @package WBDB
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class BaseController extends \Controller
{

    /**
     * Initializer.
     *
     * @access   public
     * @return \BaseController
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

}
