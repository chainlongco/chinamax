<?php

namespace Tests\Feature\Http\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class IsEmployeeTest extends TestCase
{
    /* Middleware:
        1. Create middleware -- php artisan make:middleware IsEmployee
        2. Register in Kernel.php at $routeMiddleware
        3. Apply to web.php: Route::group(['middleware' => 'isEmployee'], function () {}         
    */

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create(['name'=>'Admin','description'=>'Administrator role']);
        $managerRole = Role::create(['name'=>'Manager','description'=>'Manager role']);
        $employeeRole = Role::create(['name'=>'Employee','description'=>'Employee role']);

        $adminUser = User::create(['name'=>'Admin Only', 'email'=>'shyuadmin@yahoo.com', 'password'=>Hash::make('12345678')]);
        $managerUser = User::create(['name'=>'Manager Only', 'email'=>'shyumanager@yahoo.com', 'password'=>Hash::make('12345678')]);
        $employeeUser = User::create(['name'=>'Employee Only', 'email'=>'shyuemployee@yahoo.com', 'password'=>Hash::make('12345678')]);
        
        $adminUser->roles()->attach($adminRole);
        $managerUser->roles()->attach($managerRole);
        $employeeUser->roles()->attach($employeeRole);
    }

    /***** Order Start */
    public function test_order_success()
    {
        // Log in as employee
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access order
        $response = $this->get('/order');
        $response->assertStatus(200);
        $response->assertSee('My Orders');
    }

    public function test_order_not_employee_failed()
    {
        // Log in as administrator who without employee role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as administrator to access order
        $response = $this->get('/order');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_order_no_user_failed()
    {
        // Not log in any user to access order
        $response = $this->get('/order');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** Order End */

    /***** orders-list Start */
    public function test_orders_list_success()
    {
        // Log in as employee
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access order
        $response = $this->get('/orders-list');
        $response->assertStatus(200);   // not 302 means it can be accessed
    }

    public function test_orders_list_not_employee_failed()
    {
        // Log in as administrator who without employee role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as administrator to access order
        $response = $this->get('/orders-list');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_orders_list_no_user_failed()
    {
        // Not log in any user to access order
        $response = $this->get('/orders-list');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** orders-list End */

    /***** order-delete-id Start */
    public function test_order_delete_id_success()
    {
        // Log in as employee
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access order
        $response = $this->get('/order/delete/1');
        $response->assertStatus(302);   // not 302 means it can be accessed
        $response->assertRedirect('/order');
    }

    public function test_order_delete_id_not_employee_failed()
    {
        // Log in as administrator who without employee role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as administrator to access order
        $response = $this->get('/order/delete/1');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_order_delete_id_no_user_failed()
    {
        // Not log in any user to access order
        $response = $this->get('/order/delete/1');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** order-delete-id End */

    /***** order-edit-id Start */
    public function test_order_edit_id_success()
    {
        // Log in as employee
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access order
        $response = $this->get('/order/edit/1');
        $response->assertStatus(200);   // not 302 means it can be accessed
        $response->assertSee('My Cart');
    }

    public function test_order_edit_id_not_employee_failed()
    {
        // Log in as administrator who without employee role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as administrator to access order
        $response = $this->get('/order/edit/1');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_order_edit_id_no_user_failed()
    {
        // Not log in any user to access order
        $response = $this->get('/order/edit/1');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** order-edit-id End */
}
