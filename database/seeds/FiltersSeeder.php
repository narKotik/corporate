<?php

use Illuminate\Database\Seeder;
use Corp\Filter;

class FiltersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Filter::create([
            'title' => 'Brand Identity',
            'alias' => 'brand-identity',
        ]);
    }
}
