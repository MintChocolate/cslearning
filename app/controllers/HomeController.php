<?php

class HomeController extends BaseController {

	public function showWelcome()
	{
		$this->data['tas'] = User::tas()->get();
		$user_names = array();
		$user_names[0] = "";
		$ta_courses = array();
		$ta_courses[0] = "";
		foreach ($this->data['tas'] as $ta) {
			$user_names[$ta['id']] = $ta['name'];

			$ta_courses[$ta['id']] = "";
			$courseuser_list = Courseuser::where('user_id', '=', $ta['id'])->get();
			$added_course_list = array();
			foreach ($courseuser_list as $courseuser) {
				$course_id = $courseuser['course_id'];
				$course = Course::where('id', '=', $course_id)->get();
				$course_string = $course[0]['course_id'];
				array_push($added_course_list, $course_string);
			}
			$ta_courses[$ta['id']] = implode(", ", $added_course_list);
		}

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
				$ta1_id = $day_record['ta1_id'] == "" ? 0 : intval($day_record['ta1_id']);
				$ta2_id = $day_record['ta2_id'] == "" ? 0 : intval($day_record['ta2_id']);
				$this->data['schedule'][$day][$time][0]['name'] = $user_names[$ta1_id];
				$this->data['schedule'][$day][$time][0]['course'] = $ta_courses[$ta1_id];
				$this->data['schedule'][$day][$time][1]['name'] = $user_names[$ta2_id];	
				$this->data['schedule'][$day][$time][1]['course'] = $ta_courses[$ta2_id];			
				$this->data['times'][$day][$time] = floor($time/60) .':'. str_pad($time%60,2,0) . ' - ' . floor(($time+30)/60) . ':' . str_pad(($time+30)%60,2,0);
			}
		}

		$this->data['courses'] = array();
		$courses = Course::get();
		foreach ($courses as $course) {
			$courseObj = array();
			$courseObj['course_string'] = $course['course_id'] . ' ' . $course['course_name'];
			$courseObj['tas'] = '';

			$tas = array();
			$courseusers = Courseuser::where('course_id', '=', $course['id'])->get();
			foreach ($courseusers as $courseuser) {
				if(!is_null($courseuser['user_id'])) {
					$ta= User::where('id', '=', $courseuser['user_id'])->first();
					$ta_name = $ta['name'];
					
					if (!is_null($ta_name) && $ta_name != '' && !in_array($ta_name, $tas)) {
						array_push($tas, $ta_name);
					}
				}
			}
			$courseObj['tas'] = implode(", ", $tas);

			array_push($this->data['courses'], $courseObj);
		}

		return View::make('welcome')
			->with($this->data);
	}

	public function showNotFound()
	{
		return View::make('404')->with($this->data);
	}

}
