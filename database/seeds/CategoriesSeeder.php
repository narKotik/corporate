<?php

use Illuminate\Database\Seeder;
use Corp\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'title' => 'Блог',
            'alias' => 'blog',
        ]);
        Category::create([
            'title' => 'Компьютеры',
            'alias' => 'computers',
            'parent_id' => 1,
        ]);
        Category::create([
            'title' => 'Интересное',
            'alias' => 'iteresting',
            'parent_id' => 1,
        ]);
        Category::create([
            'title' => 'Советы',
            'alias' => 'advice',
            'parent_id' => 1,
        ]);
    }
}
