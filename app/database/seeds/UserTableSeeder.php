<?php

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();

        User::create(array('email' => 'nauzerk@cs.dal.ca', 'password' => Hash::make('password'), 'name' => 'Nauzer Kalyaniwalla', 'role' => 'admin'));
	}

}
