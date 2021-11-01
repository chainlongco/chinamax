<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SingleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('singles')->insert([
            ['name'=>'Side', 'description'=>'Select different size of side'],
            ['name'=>'Chicken Entree', 'description'=>'Select different size of chicken entree'],
            ['name'=>'Beef Entree', 'description'=>'Select different size of beef entree'],
            ['name'=>'Shrimp Entree', 'description'=>'Select different size of shrimp entree']
        ]);
    }
}
