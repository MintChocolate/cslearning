<?php

class UserController extends \BaseController {

	/**
	 * Authenticate user
	 * 
	 * @return Redirect
	 */
	public function login()
	{
		$email = Input::get('email');
		$password = Input::get('password');

		// $user = User::where('email','=',$email)->get();

		if (Auth::attempt(compact('email','password')))
		{
			if ( Auth::user()->isAdmin() )
			{
				return Redirect::intended('admin/dashboard')->withStatus('Welcome Admin.');
			}
			else
		    {
		    	return Redirect::intended('ta/dashboard')->withStatus('Welcome TA.');
		    }
		}
	
		return Redirect::to('/')->withError('Login Failed. Please try again or ask for a reminder at '. link_to('password/remind',"Password Reminder"));
	}

	/**
	 * Logout authenticated user out
	 * 
	 * @return Redirect
	 */
	public function logout()
	{
		Auth::logout();
		return Redirect::to('/')->withStatus('Good Bye.');
	}

}
