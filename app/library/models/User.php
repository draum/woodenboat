<?php

namespace WBDB\Models;

/**
 * User model.  This uses Eloquent because I only have time to re-invent so many
 * wheels.
 *
 * @package WBDB
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class User extends BaseModel  {

    protected $table = 'users';
    protected $hidden = array('password');
    protected $fillable = array(
        'first_name',
        'last_name',
        'email',
        'password'
    );
    public static $rules = array(
        'first_name' => 'Required|Between:2,20',
        'last_name' => 'Required|Between:2,20',
        'email' => 'Required|Email|Unique:users,email,:id',
    );

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->password;
    }

    /**
     * Concat the user's' full name.
     *
     * @access   public
     * @return   string
     */
    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail() {
        return $this->email;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

}
