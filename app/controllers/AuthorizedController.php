<?php

namespace WBDB\Controllers;

use Redirect;
use View;

/**
 * Extendable authorizedController, for pages that require authorization
 *
 * @package WBDB
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class AuthorizedController extends BaseController
{
    protected $whitelist = array();

    /**
     * Initializer.
     *
     * @access   public
     * @return AuthorizedController
     */
    public function __construct()
    {
        parent::__construct();

    }

}
