<?php

namespace Tests\Feature\Http\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class IsManagerTest extends TestCase
{
    /* Middleware:
        1. Create middleware -- php artisan make:middleware IsManager
        2. Register in Kernel.php at $routeMiddleware
        3. Apply to web.php: Route::group(['middleware' => 'isManager'], function () {}         
    */

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create(['name'=>'Admin','description'=>'Administrator role']);
        $ownerRole = Role::create(['name'=>'Owner','description'=>'Owner role']);
        $managerRole = Role::create(['name'=>'Manager','description'=>'Manager role']);
        $employeeRole = Role::create(['name'=>'Employee','description'=>'Employee role']);

        $adminUser = User::create(['name'=>'Admin Only', 'email'=>'shyuadmin@yahoo.com', 'password'=>Hash::make('12345678')]);
        $ownerUser = User::create(['name'=>'Owner Only', 'email'=>'shyuowner@yahoo.com', 'password'=>Hash::make('12345678')]);
        $managerUser = User::create(['name'=>'Manager Only', 'email'=>'shyumanager@yahoo.com', 'password'=>Hash::make('12345678')]);
        $employeeUser = User::create(['name'=>'Employee Only', 'email'=>'shyuemployee@yahoo.com', 'password'=>Hash::make('12345678')]);
        
        $adminUser->roles()->attach($adminRole);
        $ownerUser->roles()->attach($ownerRole);
        $managerUser->roles()->attach($managerRole);
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

    /***** Customer List Start */
    public function test_customer_list_success()
    {
        // Log in as manager
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as manager to access /customer/list
        $response = $this->get('/customer/list');
        $response->assertStatus(200);
        $response->assertSee('My Customers');
    }

    public function test_customer_list_not_manager_failed()
    {
        // Log in as employee who without employee role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access /customer/list
        $response = $this->get('/customer/list');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_customer_list_no_user_failed()
    {
        // Not log in any user to access /customer/list
        $response = $this->get('/customer/list');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** Customer List End */

    /***** Customer Add Start */
    public function test_customer_add_success()
    {
        // Log in as manager
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as manager to access /customer/add
        $response = $this->get('/customer/add');
        $response->assertStatus(200);
        $response->assertSee('New Customer');
    }

    public function test_customer_add_not_manager_failed()
    {
        // Log in as employee who without employee role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access /customer/add
        $response = $this->get('/customer/add');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_customer_add_no_user_failed()
    {
        // Not log in any user to access /customer/add
        $response = $this->get('/customer/add');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** Customer Add End */

    /***** Customer Add Submit Start */
    public function test_customer_add_submit_success()
    {
        // Log in as manager
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as manager to access /customer/add
        $response = $this->post('/customer/add');
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $this->assertEquals('The firstname field is required.', $errors['firstname'][0]);
    }

    public function test_customer_add_submit_not_manager_failed()
    {
        // Log in as employee who without employee role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access /customer/add
        $response = $this->post('/customer/add');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_customer_add_submit_no_user_failed()
    {
        // Not log in any user to access /customer/add
        $response = $this->post('/customer/add');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** Customer Add Submit End */

    /***** Customers List Start */
    public function test_customers_list_success()
    {
        // Log in as manager
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as manager to access /customers-list
        $expected = "~Jacky~";
        $this->expectOutputRegex($expected);
        $response = $this->get('/customers-list');
        $response->assertStatus(200);
    }

    public function test_customers_list_not_manager_failed()
    {
        // Log in as employee who without employee role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access /customers-list
        $response = $this->get('/customers-list');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_customers_list_no_user_failed()
    {
        // Not log in any user to access /customers-list
        $response = $this->get('/customers-list');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** Customers List End */

    /***** Customer Delete Id Start */
    public function test_customer_delete_id_success()
    {
        // Log in as manager
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as manager to access /customer/delete/{id}
        $response = $this->get('/customer/delete/10');
        $response->assertStatus(302);
        $response->assertRedirect('customer/list');
    }

    public function test_customer_delete_id_not_manager_failed()
    {
        // Log in as employee who without employee role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access /customer/delete/{id}
        $response = $this->get('/customer/delete/10');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_customer_delete_id_no_user_failed()
    {
        // Not log in any user to access /customer/delete/{id}
        $response = $this->get('/customer/delete/10');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** Customer Delete Id End */

    /***** Customer Edit Id Start */
    public function test_customer_edit_id_success()
    {
        // Log in as manager
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as manager to access /customer/edit/{id}
        $response = $this->get('/customer/edit/10');
        $response->assertStatus(302);
        $response->assertRedirect('customer/add');
    }

    public function test_customer_edit_id_not_manager_failed()
    {
        // Log in as employee who without employee role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access /customer/edit/{id}
        $response = $this->get('/customer/edit/10');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_customer_edit_id_no_user_failed()
    {
        // Not log in any user to access /customer/edit/{id}
        $response = $this->get('/customer/edit/10');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** Customer Edit Id End */
}
