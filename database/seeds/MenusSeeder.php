<?php

use Illuminate\Database\Seeder;
use Corp\Menu;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'title' => 'Главная',
            'path' => 'http://laravel.corp',
            'parent_id' => 0,
        ]);
        Menu::create([
            'title' => 'Блог',
            'path' => 'http://laravel.corp/articles',
            'parent_id' => 0,
        ]);
        Menu::create([
            'title' => 'Компьютеры',
            'path' => 'http://laravel.corp/articles/cat/computers',
            'parent_id' => 2,
        ]);
        Menu::create([
            'title' => 'Интересное',
            'path' => 'http://laravel.corp/articles/cat/iteresting',
            'parent_id' => 2,
        ]);
        Menu::create([
            'title' => 'Советы',
            'path' => 'http://laravel.corp/articles/cat/soveti',
            'parent_id' => 2,
        ]);
        Menu::create([
            'title' => 'Портфолио',
            'path' => 'http://laravel.corp/portfolios',
            'parent_id' => 0,
        ]);
        Menu::create([
            'title' => 'Контакты',
            'path' => 'http://laravel.corp/contacts',
            'parent_id' => 0,
        ]);
    }
}
