<?php

class Courseuser extends Eloquent {

	protected $fillable = array('user_id','course_id');

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function course()
	{
		return $this->belongsTo('Course');
	}
	
}