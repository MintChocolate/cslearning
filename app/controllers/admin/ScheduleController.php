<?php

class ScheduleController extends BaseController {

	function __construct()
	{
		parent::__construct();
		$this->data['navigation']['schedule']['active'] = 'class="active"';
	}

	public function index()
	{
		return View::make('admin/schedule')
			->with($this->data);
	}


}