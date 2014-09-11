<?php

class TAManagementController extends BaseController {

	function __construct()
	{
		parent::__construct();
		$this->data['navigation']['tas']['active'] = 'class="active"';
	}

	public function index()
	{
		return View::make('admin/dashboard')
			->with($this->data);
	}

}
