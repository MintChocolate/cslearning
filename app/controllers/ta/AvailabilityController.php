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
		$availabilities = Auth::user()->availabilities;

		$this->data['start'] = 600;
		$this->data['end'] = 1200;

		if (count($availabilities) == 0)
		{
			$this->data['availabilities'] = array();
			foreach ($this->data['days'] as $day)
				for ($time= $this->data['start']; $time < $this->data['end']; $time += 30)
					$this->data['availabilities'][$day][$time] = 1;
		}
		else
		{
			foreach (Auth::user()->availabilities as $availability)
				$this->data['availabilities'][$availability->day] = $availability->schedule;	
		}

		return View::make('ta/availability')
			->with( $this->data );
	}

	public function store()
	{
		$old_availabilities = Auth::user()->availabilities;
		$new_availabilities = Input::get('availabilities');

		if (count($old_availabilities) == 0)
		{
			// No availabilities exist
			// Create all from scratch
			foreach ($new_availabilities as $day => $schedule)
			{
				$availability = new Availability;
				$availability->user_id = Auth::user()->id;
				$availability->day = $day;
				$availability->schedule = $schedule;
				$availability->save();
			}
		}
		else 
		{
			//Update the existing availabilities
			foreach ($old_availabilities as $availability)
				$availability->schedule = $new_availabilities[$availability->day];
		}

		return Redirect::back()
			->withStatus('Availability has been saved!');
	}

}
