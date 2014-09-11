<?php

class BaseController extends Controller {

	function __construct()
	{
		if ( Auth::check() )
		{
			if ( Auth::user()->isAdmin() )
			{
				// Admin Navigation
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
			else
			{
				// TA Navigation
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
		}
		else
		{
			$this->data = array();
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
