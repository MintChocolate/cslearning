<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Authenticate user
	 * 
	 * @return Redirect
	 */
	public function login()
	{
		$email = Input::get('email');
		$password = Input::get('password');

		$user = User::where('email','=',$email)->get();

		if (Auth::attempt(compact('email','password')))
		{
			if ( Auth::user()->isAdmin() )
			{
				return Redirect::intended('admin/dashboard')->withStatus('Login successful');
			}
			else
		    {
		    	return Redirect::intended('ta/dashboard')->withStatus('Login successful');
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
