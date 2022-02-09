<?php

namespace Tests\Feature\Routes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Order;
use App\Models\Order_Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RouteAccessRightAdminOwnerManagerEmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create(['name'=>'Admin', 'description'=>'Administrator role']);
        $ownerRole = Role::create(['name'=>'Owner', 'description'=>'Owner role']);
        $managerRole = Role::create(['name'=>'Manager', 'description'=>'Manager role']);
        $employeeRole = Role::create(['name'=>'Employee', 'description'=>'Employee role']);  

        $adminUser = User::create(['name'=>'Admin', 'email'=>'shyuadmin@yahoo.com', 'password'=>Hash::make('12345678')]);
        $adminUser->roles()->attach($adminRole);
        $adminUser->roles()->attach($ownerRole);
        $adminUser->roles()->attach($managerRole);
        $adminUser->roles()->attach($employeeRole);
        
        $ownerUser = User::create(['name'=>'Owner', 'email'=>'shyuowner@yahoo.com', 'password'=>Hash::make('12345678')]);
        $ownerUser->roles()->attach($ownerRole);
        $ownerUser->roles()->attach($managerRole);
        $ownerUser->roles()->attach($employeeRole);

        $managerUser = User::create(['name'=>'Manager', 'email'=>'shyumanager@yahoo.com', 'password'=>Hash::make('12345678')]);
        $managerUser->roles()->attach($managerRole);
        $managerUser->roles()->attach($employeeRole);

        $employeeUser = User::create(['name'=>'Employee', 'email'=>'shyuemployee@yahoo.com', 'password'=>Hash::make('12345678')]);
        $employeeUser->roles()->attach($employeeRole);

        Customer::create([
            'first_name'=>'Jacky',
            'last_name'=>'Shyu',
            'email'=>'shyujacky@yahoo.com',
            'password'=>'$2y$04$hP7s3NfMq3Ne7r83MDokIeu0KzX1u8NZIiWRs1RjJDUZgRD2SuUOm',
            'phone'=>'12345',       // also test phone number is not 10 digits -- $phoneNumber = $order->phone; in listOrders method of OrderController.php
            'address1'=>'100 Centry Road', 
            'address2'=>'Suite 100', 
            'city'=>'Grapevine', 
            'state'=>'TX', 'zip'=>'76051', 
            'card_number'=>'1234567890123456', 
            'expired'=>'1212', 
            'cvv'=>'123'
        ]);

        Menu::create([
            'name'=>'Appetizers',
            'description'=>'A small dish before main meal',
            'level'=>0
        ]);
        Product::create([
            'name'=>'Egg Roll(5)',
            'price'=>'4.59',
            'description'=>'5 egg rolls',
            'gallery'=>'EggRoll.jpg',
            'menu_id'=>1,
            'category'=>''
        ]);
        Order::create([
            'customer_id'=>1,
            'quantity'=>1,
            'total'=>'4.97',
            'note'=>''
        ]);
        DB::table('order_products')->insert([
            'order_id'=>1,
            'product_id'=>1,
            'quantity'=>1,
            'summary'=>'Egg Roll (5) (5 egg rolls $4.59)'
        ]);
    }

    public function test_rights_for_get_order()
    {
        // Route::get('/order', function(){
        // Without any role
        $response = $this->call('GET', '/order');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('order');
        $response->assertStatus(200);
        $response->assertSee('My Orders');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('order');
        $response->assertStatus(200);
        $response->assertSee('My Orders');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('order');
        $response->assertStatus(200);
        $response->assertSee('My Orders');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('order');
        $response->assertStatus(200);
        $response->assertSee('My Orders');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));
    }

    public function test_rights_for_get_orders_list()
    {
        // Route::get('orders-list', [OrderController::class, 'listOrders']);
        // Without any role
        $response = $this->call('GET', '/orders-list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $expected = '~Order Time~';
        $this->expectOutputRegex($expected);
        $response = $this->get('orders-list');
        $response->assertStatus(200);

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $expected = '~Order Time~';
        $this->expectOutputRegex($expected);
        $response = $this->get('orders-list');
        $response->assertStatus(200);
        
        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $expected = '~Order Time~';
        $this->expectOutputRegex($expected);
        $response = $this->get('orders-list');
        $response->assertStatus(200);

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $expected = '~Order Time~';
        $this->expectOutputRegex($expected);
        $response = $this->get('orders-list');
        $response->assertStatus(200);
    
        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));
    }

    public function test_rights_for_get_order_delete()
    {
        // Route::get('/order/delete/{id}', [OrderController::class, 'orderDelete']);
        // Without any role
        $response = $this->call('GET', '/order/delete/1');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('order/delete/4');
        $response->assertStatus(302);
        $response->assertRedirect('/order');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('order/delete/4');
        $response->assertStatus(302);
        $response->assertRedirect('/order');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

       $response = $this->get('order/delete/4');
        $response->assertStatus(302);
        $response->assertRedirect('/order');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('order/delete/4');
        $response->assertStatus(302);
        $response->assertRedirect('/order');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));
    }

    public function test_rights_for_get_order_edit()
    {
        // Route::get('/order/edit/{id}', [OrderController::class, 'orderEdit']);
        // Without any role
        $response = $this->call('GET', '/order/edit/1');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('order/edit/1');
        $response->assertStatus(200);
        $response->assertSee('My Cart');
        $response->assertSee('From Order History');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));

        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('order/edit/1');
        $response->assertStatus(200);
        $response->assertSee('My Cart');
        $response->assertSee('From Order History');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('order/edit/1');
        $response->assertStatus(200);
        $response->assertSee('My Cart');
        $response->assertSee('From Order History');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('order/edit/1');
        $response->assertStatus(200);
        $response->assertSee('My Cart');
        $response->assertSee('From Order History');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));
    }
}
