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
				$this->data['schedule'][$day][$time][0]['name'] = $user_names[$ta1_id];
				$this->data['schedule'][$day][$time][0]['id'] = $ta1_id;
				$this->data['schedule'][$day][$time][1]['name'] = $user_names[$ta2_id];
				$this->data['schedule'][$day][$time][1]['id'] = $ta2_id;
				$this->data['times'][$day][$time] = floor($time/60) .':'. str_pad($time%60,2,0) . ' - ' . floor(($time+30)/60) . ':' . str_pad(($time+30)%60,2,0);
			}
		}

		return View::make('admin/schedule' )->with($this->data);
	}

	public function store() {
	$schedule = Input::get('schedule');
	foreach ($schedule as $day => $day_item) {
		foreach ($day_item as $time => $item) {
			$id1 = $item[0] == 0 ? null : $item[0];
			$id2 = $item[1] == 0 ? null : $item[1];
			Schedule::where(array('day' => $day, 'start_at' => $time))->update(array('ta1_id' => $id1, 'ta2_id' => $id2));
		}
	}
	return Redirect::back()
	->withStatus(
'Schedule has been updated!');
	}

}