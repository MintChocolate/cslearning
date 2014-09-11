<?php

class AvailabilityController extends BaseController {

	function __construct()
	{
		parent::__construct();
		$this->data['navigation']['availability']['active'] = 'class="active"';
	}

	public function index()
	{
		return View::make('ta/dashboard')
			->with( $this->data );
	}

}
