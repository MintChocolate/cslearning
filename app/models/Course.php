<?php

class Course extends Eloquent {

	protected $fillable = array('course_id','course_name');

	public function courseusers() {
		return $this->hasMany('Courseuser');
	}
	
}