<?php

namespace Tests\Feature\Routes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RouteAccessRightAdminOwnerManagerTest extends TestCase
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

    public function test_rights_for_get_customer_list()
    {
        // Route::get('/customer/list', [CustomerController::class, 'customerList'])->name('customer-list');
        // Without any role
        $response = $this->call('GET', '/customer/list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/list');
        $response->assertStatus(200);
        $response->assertSee('My Customers');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/list');
        $response->assertStatus(200);
        $response->assertSee('My Customers');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/list');
        $response->assertStatus(200);
        $response->assertSee('My Customers');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));  
    }

    public function test_rights_for_get_customer_add()
    {
        // Route::get('/customer/add', [CustomerController::class, 'customerAdd'])->name('customer-add');
        // Without any role
        $response = $this->call('GET', '/customer/add');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/add');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/add');
        $response->assertStatus(200);
        $response->assertSee('New Customer');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/add');
        $response->assertStatus(200);
        $response->assertSee('New Customer');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/add');
        $response->assertStatus(200);
        $response->assertSee('New Customer');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));  
    }

    public function test_rights_for_get_customer_submit()
    {
        // Route::post('/customer/add', [CustomerController::class, 'createUpdateCustomer'])->name('customer-submit');
        // Without any role
        $response = $this->call('POST', '/customer/add');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->post('/customer/add');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->post('/customer/add');
        $response->assertStatus(200);
        $response->assertSee('The firstname field is required');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->post('/customer/add');
        $response->assertStatus(200);
        $response->assertSee('The firstname field is required');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->post('/customer/add');
        $response->assertStatus(200);
        $response->assertSee('The firstname field is required');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));  
    }

    public function test_rights_for_get_customers_list()
    {
        // Route::get('/customers-list', [CustomerController::class, 'listCustomers']);
        // Without any role
        $response = $this->call('GET', '/customers-list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customers-list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $expected = '~Jacky~';
        $this->expectOutputRegex($expected);
        $response = $this->get('/customers-list');
        $response->assertStatus(200);

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $expected = '~Jacky~';
        $this->expectOutputRegex($expected);
        $response = $this->get('/customers-list');
        $response->assertStatus(200);
    
        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $expected = '~Jacky~';
        $this->expectOutputRegex($expected);
        $response = $this->get('/customers-list');
        $response->assertStatus(200);

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));  
    }

    public function test_rights_for_get_customer_delete()
    {
        // Route::get('/customer/delete/{id}', [CustomerController::class, 'customerDelete']);
        // Without any role
        $response = $this->call('GET', '/customer/delete/2');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/delete/2');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/delete/2');
        $response->assertStatus(302);
        $response->assertRedirect('/customer/list');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/delete/2');
        $response->assertStatus(302);
        $response->assertRedirect('/customer/list');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/delete/2');
        $response->assertStatus(302);
        $response->assertRedirect('/customer/list');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));  
    }

    public function test_rights_for_get_customer_edit()
    {
        // Route::get('/customer/edit/{id}', [CustomerController::class, 'customerEdit']);
        // Without any role
        $response = $this->call('GET', '/customer/edit/2');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/edit/2');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/edit/2');
        $response->assertStatus(302);
        $response->assertRedirect('/customer/add');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/edit/2');
        $response->assertStatus(302);
        $response->assertRedirect('/customer/add');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/customer/edit/1');
        $response->assertStatus(200);
        $response->assertSee('Edit Customer');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));  
    }
}
