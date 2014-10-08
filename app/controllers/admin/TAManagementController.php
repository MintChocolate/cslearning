<?php

class TaManagementController extends BaseController {

	function __construct()
	{
		parent::__construct();
		$this->data['navigation']['tas']['active'] = 'class="active"';
	}

	public function index()
	{
		$this->data['tas'] = User::tas()->get();

		return View::make('admin/tas')
			->with($this->data);
	}

	public function store()
	{
		$info = Input::get('ta');
		if (empty($info['name']) || empty($info['email']))
			return Redirect::route('admin.tas.index')
				->withError("You must provide both name and email.")
				->withInput();

		if ( User::where('email', '=', $info['email'])->count())
			return Redirect::route('admin.tas.index')
				->withError($info['name'] . " already exists.");

		$ta = User::create($info);
		Profile::create(array('user_id' => $ta->id));
		return Redirect::route('admin.tas.index')
			->withStatus($ta->name . " has been added.");
	}

	public function update()
	{
		$new_info = Input::get('ta');
		$ta = User::find($new_info['id']);

		$ta->email = $new_info['email'];
		$ta->name = $new_info['name'];

		$ta->save();

		return Redirect::route('admin.tas.index')
			->withStatus($ta->name . " has been updated.");
	}

	public function destroy()
	{
		$id = Input::get('id');
		$ta = User::find($id);
		User::destroy($id);
		return Redirect::route('admin.tas.index')
			->withStatus($ta->name ." has been removed.");
	}

}
