<?php

class HomeController extends BaseController {

	public function showWelcome()
	{
		$this->data['tas'] = User::tas()->get();

		$this->data['days'] = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

		//600 = 10 Hours * 60 Minutes = 10:00 AM = 10:00
		$this->data['start'] = 600;
		//1200 = 20 Hours * 60 Minutes = 8:00 PM = 20:00
		$this->data['end'] = 1200;

		$this->data['times'] = array();
		$this->data['schedule'] = array();

		foreach ($this->data['days'] as $day){
			$day_records = Schedule::where('day', $day)->orderBy('start_at', 'asc')->get();
			$this->data['times'][$day] = array();
			foreach ($day_records as $day_record) {
				$time = $day_record['start_at'];
				$this->data['schedule'][$day][$time][0] = $day_record['ta1_id'];
				$this->data['schedule'][$day][$time][1] = $day_record['ta2_id'];
				$this->data['times'][$day][$time] = floor($time/60) .':'. str_pad($time%60,2,0) . ' - ' . floor(($time+30)/60) . ':' . str_pad(($time+30)%60,2,0);
			}
		}

		return View::make('welcome')
			->with($this->data);
	}

	public function showNotFound()
	{
		return View::make('404')->with($this->data);
	}

}
