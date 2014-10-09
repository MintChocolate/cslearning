<?php

class TaAvailabilityController extends BaseController {

	function __construct()
	{
		parent::__construct();
		$this->data['navigation']['availability']['active'] = 'class="active"';
	}

	public function index()
	{
		// Days for Import/Export selection
		$this->data['days'] = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

		$this->data['tas'] = User::tas()->get();

		$this->data['changes_allowed'] = Setting::find('Availability Changes Allowed');
		if (! $this->data['changes_allowed']){
			$this->data['changes_allowed'] = new Setting;
			$this->data['changes_allowed']->name = "Availability Changes Allowed";
			$this->data['changes_allowed']->value = "Yes";
		}

		return View::make('admin/availability')
			->with($this->data);
	}

	public function remind($who)
	{
		if($who == "All")
		{
			$tas = User::tas()->get();

			foreach ($tas as $ta)
			{
				Mail::send('emails.availability_remind', array(), function($message) use ($ta)
				{
					$message->to($ta->email, $ta->name)->subject('Please update your availabiltiy!');
				});
			}

			return "Reminders Sent";
		}

		$user = User::where('name','=',$who)->first();

		if($user)
		{
			Mail::send('emails.availability_remind', array(), function($message) use ($user)
			{
				$message->to($user->email, $user->name)
					->subject('Please update your availabiltiy!');
			});

			return "Reminder Sent";
		}
		else
		{
			return "User does not exist";
		}
	}

	public function reset($who)
	{
		if($who == "All")
		{
			$tas = User::tas()->get();

			foreach ($tas as $ta)
				$ta->availabilities()->delete();

			return Redirect::back()
				->withStatus("The availabilities for All Teaching Assitants have been reset.");
		}


		$user = User::where('name','=',$who)->first();

		if($user)
		{
			$user->availabilities()->delete();
			return Redirect::back()
				->withStatus("The availability for " . $user->name . " has been reset.");
		}
		else 
		{
			return Redirect::back()
				->withError('There is no such Teaching Assistant');
		}
	}

	public function import()
	{
		if (Input::hasFIle('file'))
		{
			$day = Input::get('day');
			$file = Input::file('file');

			$csv = $this->parseCSV($file);
			
			$missing_tas = array();
			foreach ($csv as $name => $schedule)
			{
				$ta = User::where('name','=',$name)->first();
				if($ta)
				{
					$availability = $ta->availabilities()->where('day','=',$day)->first();
					if (! $availability)
						$availability = new Availability;

					$availability->day = $day;
					$availability->schedule = $schedule;
					$availability->user_id = $ta->id;
					$availability->save();
				}
				else
				{
					$missing_tas[] = $name;
				}
			}

			if (count($missing_tas) > 0)
			{
				return Redirect::back()
					->withWarning('Imported availabilities for ' . $day .'. The following Teaching Assistants could not be found in our system: ' . implode(', ', $missing_tas));
			}
			else
			{
				return Redirect::back()
					->withStatus('Imported availabilties for ' . $day . '.');
			}
		}
		return Redirect::back()->withError("No file provided");
	}

	public function export()
	{
		$days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$tas = User::tas();

		// $availabilties = array();
		// foreach ($tas as $ta)
		// 	$

		//  = User::tas->availabilties;


		return Redirect::back()->withError("No ready yet!");
	}

	private function parseCSV($csv)
	{
		$tas = array();

		if (($handle = fopen($csv->getRealPath(), "r")) !== FALSE)
		{
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				$time = $data[0];

				if ($time == '')
				{
					for ($i=1; $i < count($data); $i++)
						if(! empty($data[$i]))
							$tas[$data[$i]] = array();
				}
				else
				{
					$time = explode(':', $time);
					$time[0] = intval($time[0]) * 60;
					$time[1] = intval($time[1]);
					$time = $time[0] + $time[1];
					$i = 1;
					foreach (array_keys($tas) as $name)
						$tas[$name][$time] = $data[$i++];
				}
			}
			fclose($handle);
		}

		return $tas;
	}
}