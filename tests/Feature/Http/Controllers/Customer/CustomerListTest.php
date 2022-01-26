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

class CustomerListTest extends TestCase
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

    public function test_customer_list()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/customer/list');
        $response->assertSee('My Customers');
    }

    public function test_customer_list_table_data()
    {
        $expected = '';
        $expected .= '~<table class="table table-striped table-hover cell-border" id="customersDatatable" style="padding: 10px;">
                        <thead>
                            <tr style="border-top: 1px solid #000;">
                                <th class="text-center">First Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead><tbody><tr>~';                        
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();

        $expected = '';
        $expected .= '~<td class="align-middle">Jacky</td><td class="align-middle">Shyu</td><td class="align-middle">123-456-7890</td><td class="align-middle">shyujacky@yahoo.com</td><td><div class="row justify-content-around" style="margin:auto;"><a href="edit/1" class="col-md-5 btn btn-primary" title="Edit"><span class="bi-pencil-fill"></span></a><a href="delete/1" class="col-md-5 btn btn-danger" title="Delete"~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();

        $expected = '';
        $expected .= '~onclick="if(!confirm(~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();

        $expected = '';
        $expected .= '~Are you sure?~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();

        $expected = '';
        $expected .= '~)){return false;}~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();

        $expected = '';
        $expected .= '~<span class="bi-x-lg"></span></a></div></td></tr></tbody>~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();

        $expected = '';
        $expected .= '~<tfoot>
                            <tr>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </tfoot></table><script>~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();
       
        $expected = '';
        $expected .= '~\$\(document\)\.ready\(function\(\)\{~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();

        $expected = '';
        $expected .= '~\(\"\#usersDatatable\"\).DataTable\(\{~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();

        $expected = '';
        $expected .= '~scrollCollapse: true,~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();

        $expected = '';
        $expected .= '~\"columnDefs\": \[\{~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();

        $expected = '';
        $expected .= '~targets: \[6\],~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();

        $expected = '';
        $expected .= '~orderable: false~';
        $this->expectOutputRegex($expected);
        $controller = new CustomerController();
        $response = $controller->listCustomers();
    }
}
