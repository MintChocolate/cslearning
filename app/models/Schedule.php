<?php

class Schedule extends Eloquent {

	protected $fillable = array('day', 'start_at', 'end_at');

	public function user()
	{
		return $this->belongsTo('User');
	}	
}