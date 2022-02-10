<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name'=>'Admin', 'description'=>'Administrator role'],
            ['name'=>'Manager', 'description'=>'Manager role'],
            ['name'=>'Employee', 'description'=>'Employee role']
        ]);
    }
}
