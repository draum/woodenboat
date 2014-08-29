<?php

namespace WBDB\Controllers;

use Auth;
use Hash;
use Input;
use Redirect;
use Request;
use Validator;
use View;
use WBDB\Models\User;

/**
 * Account controller
 *
 * @package WBDB
 * @author Doug Raum
 * @copyright 2013
 * @access public
 */
class AccountController extends AuthorizedController
{
    protected $whitelist = array(
        'getLogin',
        'postLogin',
        'getRegister',
        'postRegister'
    );

    public function getIndex()
    {
        return View::make('account/index')->with('user', Auth::user());
    }

    public function postIndex()
    {
        $user = Auth::user();
        $input = Input::all();

        if (is_null($user)) {
            return Redirect::to('account')->withErrors("Invalid user or access attempt.");
        }

        // If we are updating the password, we use a different set of rules
        if (Input::get('password') <> null) {
            $rules = array(
                'first_name'            => 'Required',
                'last_name'             => 'Required',
                'password'              => 'Required|Confirmed',
                'password_confirmation' => 'Required'
            );
        } else {
            $rules = array(
                'first_name' => 'Required',
                'last_name'  => 'Required',
            );
        }
        // No change allowed
        $input['email'] = $user->email;
        $user->setRules($rules);

        if ($user->update($input)) {
            return Redirect::to('account')->with('success', 'Account updated with success!');
        } else {
            return Redirect::to('account')->withInput($input)->withErrors($user->getErrors());
        }

    }

    /**
     * Login form page.
     *
     * @access   public
     * @return   View
     */
    public function getLogin()
    {
        // Are we logged in?
        //
        if (Auth::check()) {
            return Redirect::to('account');
        }

        // Show the page.
        //
        return View::make('account/login');
    }

    /**
     * Login form processing.
     *
     * @access   public
     * @return   Redirect
     */
    public function postLogin()
    {
        // Declare the rules for the form validation.
        $rules = array(
            'email'    => 'Required|Email',
            'password' => 'Required'
        );

        // Get all the inputs.
        //
        $email = Input::get('email');
        $password = Input::get('password');

        // Validate the inputs.
        //
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success.
        //
        if ($validator->passes()) {
            // Try to log the user in.
            //
            if (Auth::attempt(
                array(
                    'email'    => $email,
                    'password' => $password
                )
            )
            ) {
                // Redirect to the users page.
                //
                return Redirect::to('account')->with('success', 'You have logged in successfully');
            } else {
                // Redirect to the login page.
                //
                return Redirect::to('account/login')->with('error', 'Email/password invalid.');
            }
        }

        // Something went wrong.
        //
        return Redirect::to('account/login')->withErrors($validator->getMessageBag());
    }

    /**
     * User account creation form page.
     *
     * @access   public
     * @return   View
     */
    public function getRegister()
    {
        // Are we logged in?
        //
        if (Auth::check()) {
            return Redirect::to('account');
        }

        // Show the page.
        //
        return View::make('account/register');
    }

    /**
     * User account creation form processing.
     *
     * @access   public
     * @return   Redirect
     */
    public function postRegister()
    {
        $rules = array(
            'first_name'            => 'Required',
            'last_name'             => 'Required',
            'email'                 => 'Required|Email|Unique:users',
            'password'              => 'Required|Confirmed',
            'password_confirmation' => 'Required'
        );
        $input = Input::all();

        $user = new User();
        $user->setRules($rules);

        if (!$user->validate($rules)) {
            return Redirect::to('account/register')->withInput($input)->withErrors($user->getErrors());
        }

        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));

        if ($user->save()) {
            return Redirect::to('account/login')->with('success', 'Account created with success!');
        }

        return Redirect::to('account/register')->withInput($input)->withErrors($user->getErrors());
    }

    /**
     * Logout page.
     *
     * @access   public
     * @return   Redirect
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('account/login')->with('success', 'Logged out with success!');
    }

}
