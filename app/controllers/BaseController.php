<?php

class BaseController extends Controller {

	function __construct()
	{
		$this->data = array();

		if ( Auth::check() )
		{
			$this->data['navigation'] = array();

			if ( Auth::user()->isAdmin() )
			{
				// Admin Navigation
				$this->data['navigation']['dashboard'] =  array(
					'name' => 'Dashboard',
					'route' => 'admin.dashboard',
					'active' => ''
				);
				$this->data['navigation']['tas'] = array(
					'name' => 'Teaching Assistants',
					'route' => 'admin.tas.index',
					'active' => ''
				);
				$this->data['navigation']['availability'] = array(
					'name' => 'Availability',
					'route' => 'admin.availability.index',
					'active' => ''
				);
				$this->data['navigation']['schedule'] = array(
					'name' => 'Schedule',
					'route' => 'admin.schedule.index',
					'active' => ''
				);
			}
			else
			{
				// TA Navigation
				$this->data['navigation']['dashboard'] =  array(
					'name' => 'Dashboard',
					'route' => 'ta.dashboard',
					'active' => ''
				);
				$this->data['navigation']['profile'] =  array(
					'name' => 'Profile',
					'route' => 'ta.profile.index',
					'active' => ''
				);
				$this->data['navigation']['availability'] = Array(
					'name' => 'Availability',
					'route' => 'ta.availability.index',
					'active' => ''
				);
			}
		}
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
