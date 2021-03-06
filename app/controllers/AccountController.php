<?php

namespace WBDB\Controllers;

use Hash;
use Input;
use Redirect;
use Request;
use Sentry;
use Validator;
use View;

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
        return View::make('account/index')->with('user', Sentry::getUser());
    }

    public function postIndex()
    {
        $user = Sentry::getUser();
        $input = Input::all();

        if (is_null($user)) {
            return Redirect::to('account')->withErrors("Invalid user or access attempt.");
        }

        // If we are updating the password, we use a different set of rules
        if (Input::get('password') <> null) {
            $rules = array(
                'password'              => 'Required|Confirmed',
                'password_confirmation' => 'Required'
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
        if (Sentry::check()) {
            return Redirect::to('/');
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
            try {
                Sentry::authenticate(
                    [
                        'email'    => $email,
                        'password' => $password,
                    ]
                );
            } catch (\Exception $e) {
                \Log::debug("Error logging in: " . $e->getMessage());
                return Redirect::to('account/login')->with('error', 'Email/password invalid.');
            }

            return Redirect::to('/')->with('success', 'You have logged in successfully');

        }

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
        if (Sentry::check()) {
            return Redirect::to('/');
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

        try {
            $user = Sentry::createUser(
                array(
                    'email'     => Input::get('email'),
                    'password'  => Input::get('password'),
                    'activated' => true,
                )
            );
        } catch         (\Exception $e) {
            \Log::debug("Error registering " . $e->getMessage());
            return Redirect::to('account/register')->with('error', 'Error in registration.');
        }

        if ($user !== null) {
            return Redirect::to('account/login')->with('success', 'Account created with success!');
        }

    }

    /**
     * Logout page.
     *
     * @access   public
     * @return   Redirect
     */
    public function getLogout()
    {
        Sentry::logout();
        return Redirect::to('account/login')->with('success', 'Logged out with success!');
    }

}
