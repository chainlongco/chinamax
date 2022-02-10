<?php

namespace Tests\Feature\Http\Controllers\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\OrderController;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create(['name'=>'Admin', 'description'=>'Administrator role']);
        $managerRole = Role::create(['name'=>'Manager', 'description'=>'Manager role']);
        $employeeRole = Role::create(['name'=>'Employee', 'description'=>'Employee role']);  

        $user = User::create(['name'=>'Admin Shyu', 'email'=>'shyuadmin@yahoo.com', 'password'=>Hash::make('12345678')]);
        $user->roles()->attach($adminRole);
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

        Order::create([
            'customer_id'=>1,
            'quantity'=>3,
            'total'=>'13.77',
            'note'=>'Mild spicy'
        ]);
    }

    public function test_delet_order_not_success()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        // Log in as administrator to access order
        $response = $this->get('/order/delete/10');
        $response->assertStatus(302);   // not 302 means it can be accessed
        $response->assertRedirect('/order');
    }

    public function test_orderDelete_success()
    {
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $order = DB::table('orders')->where('id', 1)->first();
        $this->assertEquals("13.77", $order->total);

        // Log in as administrator to access order
        $response = $this->get('/order/delete/1');
        $response->assertStatus(302);   // not 302 means it can be accessed
        $response->assertRedirect('/order');

        $order = DB::table('orders')->where('id', 1)->first();
        $this->assertEquals(null, $order);
    }
}
