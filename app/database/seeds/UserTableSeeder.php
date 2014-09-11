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

        User::create(array('email' => 'admin@cs.dal.ca', 'password' => Hash::make('admin'), 'role' => 'admin'));
        User::create(array('email' => 'ta1@cs.dal.ca', 'password' => Hash::make('password')));
        User::create(array('email' => 'andrey@cs.dal.ca'));
	}

}
