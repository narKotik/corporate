<?php

use Illuminate\Database\Seeder;
use Corp\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin'
        ]);
        Role::create([
            'name' => 'moderator'
        ]);
        Role::create([
            'name' => 'guest'
        ]);
    }
}
