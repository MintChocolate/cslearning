<?php

class ScheduleController extends BaseController {

	function __construct() {
		parent::__construct();
		$this->data['navigation']['schedule']['active'] = 'class="active"';
	}

	public function index() {
		$this->data['tas'] = User::tas()->get();
		$user_names = array();
		$user_names[0] = "";
		foreach ($this->data['tas'] as $ta) {
			$user_names[$ta['id']] = $ta['name'];
		}
		$this->data['days'] = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$this->data['start'] = 600;
		$this->data['end'] = 1200;
		$this->data['times'] = array();
		$this->data['schedule'] = array();
		foreach ($this->data['days'] as $day){
			$day_records = Schedule::where('day', $day)->orderBy('start_at', 'asc')->get();
			$this->data['times'][$day] = array();
			foreach ($day_records as $day_record) {
				$time = $day_record['start_at'];
				$ta1_id = $day_record['ta1_id'] == "" ? 0 : intval($day_record['ta1_id']);
				$ta2_id = $day_record['ta2_id'] == "" ? 0 : intval($day_record['ta2_id']);
				$this->data['schedule'][$day][$time][0] = $user_names[$ta1_id];
				$this->data['schedule'][$day][$time][1] = $user_names[$ta2_id];
				$this->data['times'][$day][$time] = floor($time/60) .':'. str_pad($time%60,2,0) . ' - ' . floor(($time+30)/60) . ':' . str_pad(($time+30)%60,2,0);
			}
		}

		$this->data['start_times'] = array();
		$this->data['end_times'] = array();
		$start = 600; /* 10:00 AM */
		$end = 1200; /* 8:00 PM */
		while ($start < $end) {
			$start_time_string = floor( $start/60) .':'. str_pad( $start % 60,2,0 );
			$end_time_string = floor( ( $start + 30 ) / 60 ) . ':' . str_pad( ( $start + 30 ) % 60, 2, 0);
			array_push($this->data['start_times'], $start_time_string);
			array_push($this->data['end_times'], $end_time_string);
			$start = $start + 30;
		}

		return View::make('admin/schedule')->with($this->data);
	}

	public function store() {
		$input = Input::all();
		$start = intval(explode(':', $input['start_time_select'])[0]) * 60 + 
			intval(explode(':', $input['start_time_select'])[1]);
		$end = intval(explode(':', $input['end_time_select'])[0]) * 60 + 
			intval(explode(':', $input['end_time_select'])[1]);

		if($start >= $end) {
			return Redirect::back()
				->withError('Invalid time selection.');
		}
		$ta_id = $input['ta_select'] == "0" ? null : intval($input['ta_select']);

		while ($start < $end) {
			$record = Schedule::where(array('day' => $input['day_select'], 'start_at' => $start))->first();
			if($input['ta_index_select'] == "0") {
				$record->ta1_id = $ta_id;
			} else {
				$record->ta2_id = $ta_id;
			}

			$record->save();
			$start += 30;

		}

		return Redirect::back()
			->withStatus('Schedule has been updated!');
	}

}