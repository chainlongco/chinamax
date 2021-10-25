<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComboDrinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('combodrinks')->insert([
            ['name'=>'Small Drink',
                'description'=>"Small fountain drink for kid's meal",
                'price'=>0,
                'gallery'=>'SoftDrinkFountain.jpg',
                'tablename'=>'fountains'],
            ['name'=>'Bottle Water',
                'description'=>"Bottle water for kid's meal",
                'price'=>0.75,
                'gallery'=>'BottleWater.jpg',
                'tablename'=>''],
        ]);
    }
}
