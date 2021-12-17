<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //$this->call(UserSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SideSeeder::class);
        $this->call(EntreeSeeder::class);
        $this->call(ComboSeeder::class);
        $this->call(FountainSeeder::class);
        $this->call(ComboDrinkSeeder::class);
        $this->call(SingleSeeder::class);
        $this->call(DrinkSeeder::class);
        $this->call(CanSeeder::class);
        $this->call(JuiceSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
