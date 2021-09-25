<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            ['name'=>'Broccoli Shrimp',
                'price'=>'10.99',
                'category'=>'Shrimp',
                'description'=>'Dinner for shrimp entree',
                'gallery'=>'BroccoliShrimp.jpg'],
            ['name'=>'Chicken Lo Mein',
            'price'=>'9.99',
            'category'=>'Lo Mein',
            'description'=>'Dinner for lo mein entree',
            'gallery'=>'ChickenLomein.jpg'],
            ['name'=>'Hunan Beef',
            'price'=>'10.99',
            'category'=>'Beef',
            'description'=>'Dinner for beef entree',
            'gallery'=>'HunanBeef.jpg'],
            ['name'=>'Kung Pao Chicken',
            'price'=>'9.99',
            'category'=>'Chicken',
            'description'=>'Dinner for chicken entree',
            'gallery'=>'KungPaoChicken.jpg'],
            ['name'=>'Mushroom Chicken',
            'price'=>'9.99',
            'category'=>'Chicken',
            'description'=>'Dinner for chicken entree',
            'gallery'=>'MushroomChicken.jpg'],
            ['name'=>'Orange Chicken',
            'price'=>'9.99',
            'category'=>'Chicken',
            'description'=>'Dinner for chicken entree',
            'gallery'=>'OrangeChicken.jpg']
        ]);
    }
}
