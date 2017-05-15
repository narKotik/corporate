<?php

use Illuminate\Database\Seeder;
use Corp\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'a@a.ru',
            'login' => 'alex',
            'password' => 'qwerty',
        ]);
    }
}
