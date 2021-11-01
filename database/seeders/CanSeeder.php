<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cans')->insert([
            ['name'=>"Coke"],
            ['name'=>"Diet Coke"],
            ['name'=>"Sprite"],
            ['name'=>"Dr Pepper"]
        ]);
    }
}
