<?php

class AvailabilityController extends BaseController {

	function __construct()
	{
		parent::__construct();
		$this->data['navigation']['availability']['active'] = 'class="active"';
	}

	public function index()
	{
		$this->data['days'] = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$this->data['availabilities'] = Auth::user()->availabilities;


		return View::make('ta/availability')
			->with( $this->data );
	}

}
