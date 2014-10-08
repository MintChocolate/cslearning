<?php

class Profile extends Eloquent {

	protected $fillable = array('user_id','about','graduate', 'year');

	public function user()
	{
		return $this->belongsTo('User');
	}
}