<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('combos')->insert([
            ['product_id'=>12, 'side'=>1, 'entree'=>1, 'drink'=>0],
            ['product_id'=>13, 'side'=>1, 'entree'=>2, 'drink'=>0],
            ['product_id'=>14, 'side'=>1, 'entree'=>3, 'drink'=>0],
            ['product_id'=>15, 'side'=>3, 'entree'=>3, 'drink'=>0],
            ['product_id'=>16, 'side'=>1, 'entree'=>1, 'drink'=>1],
        ]);
    }
}
