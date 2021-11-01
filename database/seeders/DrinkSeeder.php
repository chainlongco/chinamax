<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drinks')->insert([
            ['name'=>'Water', 'description'=>"A cup of water", 'gallery'=>'Water.jpg', 'tablename'=>''],
            ['name'=>'Bottle Water', 'description'=>'Bottle of water', 'gallery'=>'BottleWater.jpg', 'tablename'=>''],
            ['name'=>'Canned Drink', 'description'=>'A canned soft drink', 'gallery'=>'SoftDrinkCan.jpg', 'tablename'=>'cans'],
            ['name'=>'Fountain Drink', 'description'=>'Different size of fountain soft drink', 'gallery'=>'SoftDrinkFountain.jpg', 'tablename'=>'fountains'],
            ['name'=>'Fresh Juice', 'description'=>'Different size of fresh juice', 'gallery'=>'FreshJuice.jpg', 'tablename'=>'juices']
        ]);
    }
}
