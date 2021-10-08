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
            ['name'=>'Egg Roll (5)',
                'price'=>'4.59',
                'description'=>'5 egg rolls',
                'gallery'=>'EggRoll.jpg',
                'menu_id'=>'1'],
            ['name'=>'Crab Rangoon (6)',
                'price'=>'3.99',
                'description'=>'6 crab rangoons',
                'gallery'=>'CrabRangoon.jpg',
                'menu_id'=>'1'],
            ['name'=>'Fried Dumpling (5)',
                'price'=>'3.95',
                'description'=>'5 fried dumplings',
                'gallery'=>'FriedDumpling.jpg',
                'menu_id'=>'1'],
            ['name'=>'Water',
                'price'=>'0.00',
                'description'=>'A cup of water',
                'gallery'=>'',
                'menu_id'=>'2'],
            ['name'=>'Bottle Water',
                'price'=>'0.99',
                'description'=>'Bottle water',
                'gallery'=>'BottleWater.jpg',
                'menu_id'=>'2'], 
            ['name'=>'Canned Soft Drink',
                'price'=>'1.25',
                'description'=>'Soft drink canned',
                'gallery'=>'SoftDrinkCan.jpg',
                'menu_id'=>'2'],
            ['name'=>'Funtain Soft Drink Small',
                'price'=>'1.59',
                'description'=>'Small size funtain soft drink',
                'gallery'=>'SoftDrinkFuntain.jpg',
                'menu_id'=>'2'],
            ['name'=>'Funtain Soft Drink Medium',
                'price'=>'1.89',
                'description'=>'Medium size funtain soft drink',
                'gallery'=>'SoftDrinkFuntain.jpg',
                'menu_id'=>'2'],
            ['name'=>'Funtain Soft Drink Large',
                'price'=>'2.19',
                'description'=>'Large size funtain soft drink',
                'gallery'=>'SoftDrinkFuntain.jpg',
                'menu_id'=>'2'],    
            ['name'=>'Small Fresh Fruit Juice',
                'price'=>'3.99',
                'description'=>'Small size fresh fruit juice',
                'gallery'=>'FreshJuice.jpg',
                'menu_id'=>'2'],
            ['name'=>'Regular Fresh Fruit Juice',
                'price'=>'4.99',
                'description'=>'Regular size fresh fruit juice',
                'gallery'=>'FreshJuice.jpg',
                'menu_id'=>'2'],
            ['name'=>'Small Platter',
                'price'=>'6.40',
                'description'=>'Any 1 side & 1 entree',
                'gallery'=>'',
                'menu_id'=>'3'],      
            ['name'=>'Regular Platter',
                'price'=>'7.58',
                'description'=>'Any 1 side & 2 entrees',
                'gallery'=>'',
                'menu_id'=>'3'],
            ['name'=>'Large Platter',
                'price'=>'8.93',
                'description'=>'Any 1 side & 3 entrees',
                'gallery'=>'',
                'menu_id'=>'3'],
            ['name'=>'Party Tray',
                'price'=>'23.99',
                'description'=>'3 side & 8 entrees',
                'gallery'=>'',
                'menu_id'=>'3'],
            ['name'=>'Side Small',
                'price'=>'2.49',
                'description'=>'Small size of side',
                'gallery'=>'',
                'menu_id'=>'4'],
            ['name'=>'Side Regular',
                'price'=>'2.99',
                'description'=>'Regular size of side',
                'gallery'=>'',
                'menu_id'=>'4'],
            ['name'=>'Side Large',
                'price'=>'3.49',
                'description'=>'Large size of side',
                'gallery'=>'',
                'menu_id'=>'4'],    
            ['name'=>'Chicken Small',
                'price'=>'5.49',
                'description'=>'Small size of chicken entree',
                'gallery'=>'',
                'menu_id'=>'4'], 
            ['name'=>'Chicken Regular',
                'price'=>'5.99',
                'description'=>'Regular size of chicken entree',
                'gallery'=>'',
                'menu_id'=>'4'],
            ['name'=>'Chicken Large',
                'price'=>'6.49',
                'description'=>'Large size of chicken entree',
                'gallery'=>'',
                'menu_id'=>'4'],          
            ['name'=>'Beef Small',
                'price'=>'5.99',
                'description'=>'Small Size of beef entree',
                'gallery'=>'',
                'menu_id'=>'4'],
            ['name'=>'Beef Regular',
                'price'=>'6.49',
                'description'=>'Regular Size of beef entree',
                'gallery'=>'',
                'menu_id'=>'4'],
            ['name'=>'Beef Large',
                'price'=>'6.99',
                'description'=>'Small Size of beef entree',
                'gallery'=>'',
                'menu_id'=>'4'],
            ['name'=>'Shrimp Small',
                'price'=>'6.49',
                'description'=>'Small size of shrimp entree',
                'gallery'=>'',
                'menu_id'=>'4'],
            ['name'=>'Shrimp Regular',
                'price'=>'6.99',
                'description'=>'Regular size of shrimp entree',
                'gallery'=>'',
                'menu_id'=>'4'],
            ['name'=>'Shrimp Large',
                'price'=>'7.49',
                'description'=>'Large size of shrimp entree',
                'gallery'=>'',
                'menu_id'=>'4'],    
            ['name'=>"Kid's Meal",
                'price'=>'4.99',
                'description'=>'One small drink, one side and one entree',
                'gallery'=>'',
                'menu_id'=>5]         
        ]);
    }
}
