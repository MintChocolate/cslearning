<?php

class ProfileController extends BaseController {

	function __construct()
	{
		parent::__construct();
		$this->data['navigation']['profile']['active'] = 'class="active"';
	}

	public function index()
	{
		$user = Auth::user();
		$this->data['name'] = $user->name;
		$this->data['profile'] = $user->profile;
		
		$courseuser_list = Courseuser::where('user_id', '=', $user->id)->get();
		$added_course_list = array();
		foreach ($courseuser_list as $courseuser) {
			$course_id = $courseuser['course_id'];
			$course = Course::where('id', '=', $course_id)->get();
			$course_string = $course[0]['course_id'] . ' ' . $course[0]['course_name'];
			array_push($added_course_list, $course_string);
		}
		$this->data['added_courses'] = $added_course_list;

		$all_courses = Course::get();
		$can_be_added_courses = array();
		foreach ($all_courses as $course) {
			$course_string = $course['course_id'] . ' ' . $course['course_name'];
			if (!in_array($course_string, $added_course_list)) {
				
				array_push($can_be_added_courses, array('id' => $course['id'],
													'course_string' => $course_string));
			}
			
		}
		$this->data['can_be_added_courses'] = $can_be_added_courses;
		return View::make('ta/profile')
			->with($this->data);
	}

	public function update()
	{
		$new_profile = Input::get('profile');

		$name = Input::get('name');

		if (empty($name))
			return Redirect::back()
				->withError('You must provide a name.')
				->withInput(Input::except('name'));

		if (!is_null($new_profile['year']) && $new_profile['year'] < 1)
			return Redirect::back()
				->withError('You must be at least in your first year.')
				->withInput(Input::except('profile[year]'));

		$user = Auth::user();
		$user->name = $name;
		$user->save();

		$current_profile = Auth::user()->profile;

		$current_profile->about = $new_profile['about'];
		$current_profile->graduate = $new_profile['graduate'];
		$current_profile->year = $new_profile['year'];
		
		$current_profile->save();
		// create new courses if specified
		$new_course_id = Input::get('new_course_id');
		$new_course_name = Input::get('new_course_name');
		$all_courses = Course::get();
		foreach ($all_courses as $course) {
			if(!is_null(Input::get($course['id']))) {
				$new_course_user = Courseuser::where(array('course_id' => $course['id'],
													'user_id' => $user->id))->first();
				if (is_null($new_course_user)){
					$new_course_user = Courseuser::create(['course_id' => $course['id'],
													  'user_id' => $user->id]);
				}
			}
		}

		if (!is_null($new_course_id) && !is_null($new_course_name)) {
			if ($new_course_id != '' && $new_course_name != '') {
				$new_course_string = 'CSCI' . $new_course_id;
				foreach ($all_courses as $course) {
					if($new_course_string == $course['course_id']) {
						return Redirect::back()
							->withError('This course has already been enter.');
					}
				}

				$new_course = Course::where('course_id', '=', $new_course_string)->first();
				if($new_course == null) {
					$new_course = Course::create(['course_id' => 'CSCI' . $new_course_id,
												  'course_name' => $new_course_name]);
					$new_course->save();
				}
				$new_course_user = Courseuser::where(array('course_id' => $new_course->id,
													'user_id' => $user->id))->first();
				if (is_null($new_course_user)){
					$new_course_user = Courseuser::create(['course_id' => $new_course->id,
													  'user_id' => $user->id]);
				}
			}
		}

		return Redirect::back()
			->withStatus('Your profile has been updated.');
	}

	public function image()
	{
		if (Input::hasFile('file'))
		{
			$image = Input::file('file');

			$type = $image->getMimeType();

			$type = explode('/',$type);
			
			$extension = $type[1];
			$type = $type[0];

			if ($type == "image")
			{
				$name = Auth::user()->name . "." . $extension;
				$image->move('images', $name);
				$profile = Auth::user()->profile;
				$profile->image = $name;
				$profile->save();
				return Redirect::back()
					->withStatus('Your image has been updated.');
			}
			
			return Redirect::back()
				->withError('You can upload only images.');
		}

		return Redirect::back()
			->withError('No file was provided.');
	}

	public function show($name)
	{
		$user = User::where('name','=',$name)->first();

		if (!$user || $user->isAdmin())
			App::abort(404);

		$this->data['ta'] = $user;
		$this->data['profile'] = $user->profile;

		return View::make('ta/show')
			->with($this->data);
	}
}