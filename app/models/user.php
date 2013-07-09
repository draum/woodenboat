<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * User model.  This uses Eloquent because I only have time to re-invent so many wheels.
 * 
 * @package WBDB   
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */ 
class User extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

    /**
     * Get the user full name.
     *
     * @access   public
     * @return   string
     */
    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
	
	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}
