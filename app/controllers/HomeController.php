<?php

class HomeController extends BaseController {

	public function showWelcome()
	{
		$this->data['tas'] = User::tas()->get();
		return View::make('welcome')
			->with($this->data);
	}

}
