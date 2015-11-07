<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';

	protected $fillable = array('email', 'name');

	protected $hidden = array('password', 'remember_token');

	public function isAdmin()
	{
		return $this->role == "admin";
	}

	public function availabilities()
	{
		return $this->hasMany('Availability');
	}

	public function courseusers() {
		return $this->hasMany('Courseuser');
	}

	public function schedules()
	{
		return $this->hasMany('Schedule');
	}

	public function profile()
	{
		return $this->hasOne('Profile');
	}

	public function scopeTas($query)
    {
        return $query->where('role', '=', 'ta');
    }
}
