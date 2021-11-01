<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JuiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('juices')->insert([
            ['name'=>'Orange'],
            ['name'=>'Kiwi'],
            ['name'=>'Watermelon'],
            ['name'=>'Strawberry']
        ]);
    }
}
