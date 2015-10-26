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

Route::get('404', array('uses' => 'HomeController@showNotFound','as' => '404'));
Route::get('/', array('uses' => 'HomeController@showWelcome', 'as' => 'home'));

// **********************************************
// *											*
// *			General User Routes 			*
// *											*
// **********************************************
Route::post('users/login', array('uses' => 'UserController@login', 'as' => 'login'));
Route::get('users/logout', array('uses' => 'UserController@logout', 'as' => 'logout'));


// **********************************************
// *											*
// *				Admin Routes 				*
// *											*
// **********************************************
Route::group(array('prefix' => 'admin', 'before' => array('auth','admin')), function()
{
    Route::get('dashboard', array('uses' => 'AdminController@dashboard', 'as' => 'admin.dashboard'));
    Route::resource('tas', 'TaManagementController', array('only' => array('index','store','update','destroy')));
    Route::resource('availability', 'TaAvailabilityController', array('only' => array('index','store')));
    Route::resource('schedule', 'ScheduleController');
    Route::post('availability/import', array('uses' => 'TaAvailabilityController@import', 'as' => 'admin.availability.import'));
    Route::post('availability/export', array('uses' => 'TaAvailabilityController@export', 'as' => 'admin.availability.export'));
    Route::post('availability/remind/{email}', array('uses' => 'TaAvailabilityController@remind', 'as' => 'admin.availability.remind'));
    Route::post('availability/reset/{email}', array('uses' => 'TaAvailabilityController@reset', 'as' => 'admin.availability.reset'));
    Route::resource('settings', 'SettingController', array('only' => 'store'));
});


// **********************************************
// *											*
// *				TA Routes 					*
// *											*
// **********************************************
Route::group(array('prefix' => 'ta'), function()
{
    Route::group(array('before' => array('auth','ta')),function(){
        Route::get('dashboard', array('uses' => 'TaController@dashboard', 'as' => 'ta.dashboard'));
        Route::resource('availability', 'AvailabilityController', array('only' => array('index','store')));
        Route::post('availability/hours', array('uses' => 'AvailabilityController@hours', 'as' => 'ta.availability.hours'));
        Route::resource('profile', 'ProfileController', array('only' => array('index','update')));
        Route::post('profile/image', array('uses' => 'ProfileController@image', 'as' => 'ta.profile.image'));
    });
	
    Route::get('profile/{name}', array('uses' => 'ProfileController@show', 'as' => 'ta.profile.show'));
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

Route::filter('ta', function()
{
    if ( Auth::user()->isAdmin() )
    {
        return Redirect::route('admin.dashboard');
    }
});