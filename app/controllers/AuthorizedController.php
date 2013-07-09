<?php

/**
 * AuthorizedController
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
     * @return \AuthorizedController
     */
	public function __construct()
	{
        parent::__construct();
		// Check if the user is logged in.
		$this->beforeFilter('auth', array('except' => $this->whitelist));
	}
}
