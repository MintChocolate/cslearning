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

		//600 = 10 Hours * 60 Minutes = 10:00 AM = 10:00
		$this->data['start'] = 600;
		//1200 = 20 Hours * 60 Minutes = 8:00 PM = 20:00
		$this->data['end'] = 1200;

		$this->data['times'] = array();
		$this->data['availabilities'] = array();
		foreach ($this->data['days'] as $day){
			$this->data['availabilities'][$day] = array();
			$this->data['times'][$day] = array();
			for ($time= $this->data['start']; $time < $this->data['end']; $time += 30){
				$this->data['availabilities'][$day][$time] = 1;
				$this->data['times'][$day][$time] = floor($time/60) .':'. str_pad($time%60,2,0) . ' - ' . floor(($time+30)/60) . ':' . str_pad(($time+30)%60,2,0);
			}
		}
		if (count($availabilities) > 0)
			foreach (Auth::user()->availabilities as $availability)
				$this->data['availabilities'][$availability->day] = $availability->schedule;

		$this->data['requested_hours'] = Auth::user()->profile->requested_hours;

		$availabilities = $this->data['availabilities'];

		$this->data['cant_work'] = array();
		foreach ($this->data['days'] as $day){
			// Works fine, not idea why PHP parser complains
			if (empty(array_filter($availabilities[$day])))
				$this->data['cant_work'][$day] = true;
		}

		$this->data['changes_allowed'] = Setting::find('Availability Changes Allowed');
		if (! $this->data['changes_allowed']){
			$this->data['changes_allowed'] = new Setting;
			$this->data['changes_allowed']->name = "Availability Changes Allowed";
			$this->data['changes_allowed']->value = "Yes";
		}

		return View::make('ta/availability')
			->with( $this->data );
	}

	public function store()
	{
		$availabilities = Input::get('availabilities');

		foreach ($availabilities as $day => $schedule)
		{
			$availability = Auth::user()->availabilities()->where('day','=',$day)->first();
			if(!$availability)
				$availability = new Availability;

			$availability->user_id = Auth::user()->id;
			$availability->day = $day;
			$availability->schedule = $schedule;
			$availability->save();
		}
		
		return Redirect::back()
			->withStatus('Your availability has been saved!');
	}

	public function hours()
	{
		$hours = Input::get('hours');

		if($hours < 2)
			return Redirect::back()
				->withError('You cannot work less than 2 hours per week.');

		if($hours > 15)
			return Redirect::back()
				->withError('You cannot work more than 15 hours per week.');

		$profile = Auth::user()->profile;
		$profile->requested_hours = $hours;
		$profile->save();

		return Redirect::back()
			->withStatus('Your requested hours per week have been updated.');
	}

}
