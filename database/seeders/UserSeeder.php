<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = DB::table('roles')->select('id')->where('name', 'Admin')->first();
        $ownerRole = DB::table('roles')->select('id')->where('name', 'Owner')->first();
        $managerRole = DB::table('roles')->select('id')->where('name', 'Manager')->first();
        $employeeRole = DB::table('roles')->select('id')->where('name', 'Employee')->first();

        $admin = new User();
        $admin->name = "Admin";
        $admin->email = "Admin@yahoo.com";
        $admin->password = Hash::make('1234');
        $admin->save();
        $admin->roles()->attach($adminRole);
        $admin->roles()->attach($ownerRole);
        $admin->roles()->attach($managerRole);
        $admin->roles()->attach($employeeRole);

        $owner = new User();
        $owner->name = "Owner";
        $owner->email = "Owner@yahoo.com";
        $owner->password = Hash::make('1234');
        $owner->save();
        $owner->roles()->attach($ownerRole);
        $owner->roles()->attach($managerRole);
        $owner->roles()->attach($employeeRole);

        $manager = new User();
        $manager->name = "Manager";
        $manager->email = "Manager@yahoo.com";
        $manager->password = Hash::make('1234');
        $manager->save();
        $manager->roles()->attach($managerRole);
        $manager->roles()->attach($employeeRole);

        $employee = new User();
        $employee->name = "Employee";
        $employee->email = "Employee@yahoo.com";
        $employee->password = Hash::make('1234');
        $employee->save();
        $employee->roles()->attach($employeeRole);
    }
}
