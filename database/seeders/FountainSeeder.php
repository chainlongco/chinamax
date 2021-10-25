<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FountainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fountains')->insert([
            ['name'=>'Coke'],
            ['name'=>'Diet Coke'],
            ['name'=>'Coke Zero'],
            ['name'=>'Root Beer'],
            ['name'=>'Fruitopia'],
            ['name'=>'Nestea'],
            ['name'=>'Sprite'],
            ['name'=>'Fanta']
        ]);
    }
}
