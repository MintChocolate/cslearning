<?php

class SettingController extends BaseController {
	public function store()
	{
		$new_setting = Input::get('setting');
		$setting = Setting::find($new_setting['name']);
		if($setting)
		{
			$setting->value = $new_setting['value'];
			$setting->save();
		}
		else
		{
			$setting = Setting::create($new_setting);
		}
		return Redirect::back()
			->withStatus($setting->name . " has been set to " . $setting->value . ".");
	}
}