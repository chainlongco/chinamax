<?php

namespace Tests\Feature\Http\Controllers\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create(['name'=>'Admin', 'description'=>'Administrator role']);
        $ownerRole = Role::create(['name'=>'Owner', 'description'=>'Owner role']);
        $managerRole = Role::create(['name'=>'Manager', 'description'=>'Manager role']);
        $employeeRole = Role::create(['name'=>'Employee', 'description'=>'Employee role']);  

        $user = User::create(['name'=>'Admin Shyu', 'email'=>'shyuadmin@yahoo.com', 'password'=>Hash::make('12345678')]);
        $user->roles()->attach($adminRole);
        $user->roles()->attach($ownerRole);
        $user->roles()->attach($managerRole);
        $user->roles()->attach($employeeRole);

        Customer::create([
            'first_name'=>'Jacky',
            'last_name'=>'Shyu',
            'email'=>'shyujacky@yahoo.com',
            'password'=>'$2y$04$hP7s3NfMq3Ne7r83MDokIeu0KzX1u8NZIiWRs1RjJDUZgRD2SuUOm',
            'phone'=>'1234567890',
            'address1'=>'100 Centry Road', 
            'address2'=>'Suite 100', 
            'city'=>'Grapevine', 
            'state'=>'TX', 'zip'=>'76051', 
            'card_number'=>'1234567890123456', 
            'expired'=>'1212', 
            'cvv'=>'123'
        ]);
    }

    public function test_delete_customer_who_does_not_exist()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/customer/delete/2');
        $response->assertRedirect(route('customer-list'));
    }

    public function test_delete_customer_success()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $customer = DB::table('customers')->where('id', 1)->first();
        $this->assertEquals('Jacky', $customer->first_name);

        $response = $this->call('GET', '/customer/delete/1');
        $response->assertRedirect(route('customer-list'));

        $customer = DB::table('customers')->where('id', 1)->first();
        $this->assertEquals(null, $customer);
    }
}
