<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('test', function() {
	return View::make('test');
});

Route::get('/', array('uses' => 'HomeController@showWelcome', 'as' => 'home'));

// **********************************************
// *											*
// *			General User Routes 			*
// *											*
// **********************************************
Route::post('users/login', array('uses' => 'UserController@login'));
Route::get('users/logout', array('uses' => 'UserController@logout'));
Route::resource('users','UserController');


// **********************************************
// *											*
// *				Admin Routes 				*
// *											*
// **********************************************
Route::group(array('prefix' => 'admin', 'before' => array('auth','admin')), function()
{
    Route::get('dashboard', array('uses' => 'AdminController@dashboard', 'as' => 'admin.dashboard'));
    Route::resource('tas','TAManagementController');
});


// **********************************************
// *											*
// *				TA Routes 					*
// *											*
// **********************************************
Route::group(array('prefix' => 'ta', 'before' => 'auth'), function()
{
	Route::get('dashboard', array('uses' => 'TaController@dashboard', 'as' => 'ta.dashboard'));
	Route::resource('availability', 'AvailabilityController');
});


// **********************************************
// *											*
// *			Password Routes 				*
// *											*
// **********************************************
Route::controller('password', 'PasswordController');


// **********************************************
// *											*
// *				Filters 					*
// *											*
// **********************************************
Route::filter('admin', function()
{
    if ( ! Auth::user()->isAdmin() )
    {
    	return Redirect::route('ta.dashboard');
    }
});