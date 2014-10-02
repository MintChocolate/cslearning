<?php

class TaController extends BaseController {

	function __construct()
	{
		parent::__construct();
		$dashboard =  array(
			'name' => 'Dashboard',
			'route' => 'ta.dashboard',
			'active' => ''
		);
		$availability = Array(
			'name' => 'Availability',
			'route' => 'ta.availability.index',
			'active' => ''
		);

		$this->data['navigation'] = compact('dashboard', 'availability');
	}

	public function dashboard()
	{
		$this->data['navigation']['dashboard']['active']  = 'class="active"';
		
		return View::make('ta/dashboard')
			->with( $this->data );
	}

}
