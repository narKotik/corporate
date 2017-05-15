<?php

use Illuminate\Database\Seeder;
use Corp\Permission;


class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'VIEW_ADMIN'
        ]);
        Permission::create([
            'name' => 'VIEW_ADMIN_ARTICLES'
        ]);
        Permission::create([
            'name' => 'ADD_ARTICLES'
        ]);
        Permission::create([
            'name' => 'UPDATE_ARTICLES'
        ]);
        Permission::create([
            'name' => 'DELETE_ARTICLES'
        ]);
        Permission::create([
            'name' => 'VIEW_ADMIN_USERS'
        ]);
        Permission::create([
            'name' => 'EDIT_USERS'
        ]);
        Permission::create([
            'name' => 'CREATE_USERS'
        ]);
        Permission::create([
            'name' => 'DELETE_USERS'
        ]);
        Permission::create([
            'name' => 'VIEW_ADMIN_PERMITION'
        ]);
        Permission::create([
            'name' => 'EDIT_PERMITION'
        ]);
        Permission::create([
            'name' => 'VIEW_ADMIN_MENU'
        ]);
        Permission::create([
            'name' => 'EDIT_MENU'
        ]);
        Permission::create([
            'name' => 'UPDATE_MENU'
        ]);
        Permission::create([
            'name' => 'DELETE_MENU'
        ]);
    }
}
