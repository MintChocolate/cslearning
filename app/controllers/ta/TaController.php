<?php

class TaController extends BaseController {

	public function dashboard()
	{
		$this->data['navigation']['dashboard']['active']  = 'class="active"';
		
		return View::make('ta/dashboard')
			->with( $this->data );
	}

}
