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
use App\Models\Restaurant;
use App\Http\Controllers\OrderController;

class OrderListTest extends TestCase
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

        Restaurant::create([
            'name'=>'Chinamax',
            'tax_rate'=>0.0825
        ]);
    }

    public function test_order_list_table_data()
    {

        $expected = '~First Name~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Last Name~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Phone~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Email~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Quantity~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Subtotal~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Tax~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Total~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Order Time~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Updated Time~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Actions~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Jacky~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~Shyu~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~214-680-8281~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~shyujacky@yahoo.com~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~3~';
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~13.77~';  // subtotal
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~1.14~';   // Tax
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();

        $expected = '~14.91~';   // total
        $this->expectOutputRegex($expected);
        $controller = new OrderController();
        $response = $controller->listOrders();
    }
}
