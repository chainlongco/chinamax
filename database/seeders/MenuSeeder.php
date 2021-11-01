<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            ['name'=>'Appetizers',
                'description'=>'A small dish before main meal',
                'level'=>'0'],
            ['name'=>'Drinks',
                'description'=>'Water, Fresh Juice, Soft Drinks...',
                'level'=>'0'],
            ['name'=>'Combo',
                'description'=>'Side & Entree combination',
                'level'=>'1'],
            ['name'=>'Individual Side/Entree',
                'description'=>'Side or Entree only',
                'level'=>'1']
        ]);
    }
}
