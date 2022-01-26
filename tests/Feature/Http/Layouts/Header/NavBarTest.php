<?php

namespace Tests\Feature\Http\Layouts\Header;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class NavBarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
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

    }

    public function test_nav_bar_without_any_user_login()
    {
        $response = $this->call('GET', '/login');
        $response->assertStatus(200);

        $response->assertSeeInOrder(['ChinaMax', 'Menu', 'Cart', 'Checkout', 'Cart', '0', 'Customer', 'Login', 'Register', 'User', 'Login', 'Register']);
    }

    public function test_nav_bar_admin_login()
    {    

        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('cart'); // In order to see navbar
        $response->assertSee('ChinaMax');
        $response->assertSeeInOrder(['ChinaMax', 'Menu', 'Cart', 'Checkout', 'Order', 'Customer', 'My Customers', 'Add Customer', 'User', 'Cart', '0', 'Customer', 'Login', 'Register', 'Admin', 'Logout']);
    }

    public function test_nav_bar_owner_login()
    {
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('cart'); // In order to see navbar
        $response->assertStatus(200);
        $response->assertSee('ChinaMax');
        $response->assertSeeInOrder(['ChinaMax', 'Menu', 'Cart', 'Checkout', 'Order', 'Customer', 'My Customers', 'Add Customer', 'Cart', '0', 'Customer', 'Login', 'Register', 'Owner', 'Logout']);
    }

    public function test_nav_bar_manager_login()
    {
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('cart'); // In order to see navbar
        $response->assertStatus(200);
        $response->assertSee('ChinaMax');
        $response->assertSeeInOrder(['ChinaMax', 'Menu', 'Cart', 'Checkout', 'Order', 'Customer', 'My Customers', 'Add Customer', 'Cart', '0', 'Customer', 'Login', 'Register', 'Manager', 'Logout']);
    }

    public function test_nav_bar_employee_login()
    {
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('cart'); // In order to see navbar
        $response->assertStatus(200);
        $response->assertSee('ChinaMax');
        $response->assertSeeInOrder(['ChinaMax', 'Menu', 'Cart', 'Checkout', 'Order', 'Cart', '0', 'Customer', 'Login', 'Register', 'Employee', 'Logout']);
    }
}
