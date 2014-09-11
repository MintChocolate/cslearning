<?php

class AdminController extends BaseController {

	public function dashboard()
	{
		$this->data['navigation']['dashboard']['active']  = 'class="active"';

		return View::make('admin/dashboard')
			->with( $this->data );
	}

}
