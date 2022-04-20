<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('restaurants')->insert([
            ['name'=>'Chinamax', 'year_founded'=>'2022', 'tax_rate'=>'0.0825', 'phone'=>'2146808281', 'email'=>'shyujacky@yahoo.com', 'address1'=>'4444 Timber Crest Ct.', 'address2'=>'', 'city'=>'Grapevine', 'state'=>'Texas', 'zip'=>'76051']
        ]);
    }
}
