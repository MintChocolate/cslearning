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

		if ($new_profile['year'] < 1)
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