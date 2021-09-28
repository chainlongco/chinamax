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
                'price'=>'0',
                'description'=>'A small dish before main meal'],
            ['name'=>'Drinks',
                'price'=>'0',
                'description'=>'Water, Fresh Juice, Soft Drinks...'],
            ['name'=>'Small Platter',
                'price'=>'6.40',
                'description'=>'Any 1 Side & 1 Entree'],
            ['name'=>'Regular Platter',
                'price'=>'7.58',
                'description'=>'Any 1 Side & 2 Entrees'],
            ['name'=>'Large Platter',
                'price'=>'8.93',
                'description'=>'Any 1 Side & 3 Entrees'],
            ['name'=>'Party Tray',
                'price'=>'28.99',
                'description'=>'2 big Sides & 8 Entrees'],     
        ]);
    }
}
