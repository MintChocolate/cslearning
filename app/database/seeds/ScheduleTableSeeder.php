<?php

class ScheduleTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$week_days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
		for($i = 0; $i < 7; $i++) {

			//600 = 10 Hours * 60 Minutes = 10:00 AM = 10:00
			$start = 600;
			//1200 = 20 Hours * 60 Minutes = 8:00 PM = 20:00
			$end = 1200;
			
			while ($start < $end) {
				Schedule::create(
					array('day' => $week_days[$i], 
						  'start_at' => $start, 
						  'end_at' => $start + 30));
				$start += 30;
			}
		}


	}

}