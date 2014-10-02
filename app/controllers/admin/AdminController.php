<?php

class AdminController extends BaseController {

	function __construct()
	{
		parent::__construct();
		$dashboard =  array(
			'name' => 'Dashboard',
			'route' => 'admin.dashboard',
			'active' => ''
		);
		$tas = array(
			'name' => 'Teaching Assistants',
			'route' => 'admin.tas.index',
			'active' => ''
		);

		$this->data['navigation'] = compact('dashboard', 'tas');
	}

	public function dashboard()
	{
		$this->data['navigation']['dashboard']['active']  = 'class="active"';

		return View::make('admin/dashboard')
			->with( $this->data );
	}

}
