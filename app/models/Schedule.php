<?php

class Schedule extends Eloquent {

	protected $fillable = array('day', 'start_at', 'end_at', 'ta1_id', 'ta2_id');

	public function user()
	{
		return $this->belongsTo('User');
	}	
}