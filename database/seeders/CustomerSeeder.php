<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            ['first_name'=>'Jacky', 'last_name'=>'Shyu', 'phone'=>'2146808281', 'email'=>'shyujacky@yahoo.com', 'password'=>Hash::make('1234'), 'address1'=>'4436 Timber Crest Ct.', 'address2'=>'', 'city'=>'Grapevine', 'state'=>'Texas', 'zip'=>'76051', 'card_number'=>'1234567890123456', 'expired'=>'1234', 'cvv'=>'123']
        ]);
    }
}
