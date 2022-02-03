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

class IsAdminTest extends TestCase
{
    /* Middleware:
        1. Create middleware -- php artisan make:middleware IsAdmin
        2. Register in Kernel.php at $routeMiddleware
        3. Apply to web.php: Route::group(['middleware' => 'isAdmin'], function () {}         
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
    }

    /***** User List Start */
    public function test_user_list_success()
    {
        // Log in as admin
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as admin to access /user/list
        $response = $this->get('/user/list');
        $response->assertStatus(200);
        $response->assertSee('My Users');
    }

    public function test_user_list_not_admin_failed()
    {
        // Log in as employee who without admin role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access /user/list
        $response = $this->get('/user/list');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_user_list_no_user_failed()
    {
        // Not log in any user to access /user/list
        $response = $this->get('/user/list');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** User List End */

    /***** Users List Start */
    public function test_users_list_success()
    {
        // Log in as admin
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as admin to access /users-list
        $expected = "~Admin~";
        $this->expectOutputRegex($expected);
        $response = $this->get('/users-list');
        $response->assertStatus(200);
    }

    public function test_users_list_not_admin_failed()
    {
        // Log in as employee who without employee role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access /users-list
        $response = $this->get('/users-list');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_users_list_no_user_failed()
    {
        // Not log in any user to access /users-list
        $response = $this->get('/users-list');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** Users List End */

    /***** User Delete Start */
    public function test_user_delete_success()
    {
        // Log in as admin
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as admin to access /user/delete
        $response = $this->get('/user-delete', ['id'=>8]);
        //$response->assertStatus(200);
        $message = $response->json()['msg'];
        $this->assertEquals('Deletion failed.', $message);
    }

    public function test_user_delete_not_admin_failed()
    {
        // Log in as employee who without admin role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access /users-list
        $response = $this->get('/user-delete');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_user_delete_no_user_failed()
    {
        // Not log in any user to access /user-delete
        $response = $this->get('/user-delete');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** User Delete End */

    /***** User Edit Start */
    public function test_user_edit_success()
    {
        // Log in as admin
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as admin to access /user/delete
        $response = $this->get('/user-edit', ['id'=>8]);
        //$response->assertStatus(200);
        $message = $response->json()['msg'];
        $this->assertEquals('User not found.', $message);
    }

    public function test_user_edit_not_admin_failed()
    {
        // Log in as employee who without admin role
        $response = $this->get('/login');
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        // Log in as employee to access /users-list
        $response = $this->get('/user-edit');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }

    public function test_user_edit_no_user_failed()
    {
        // Not log in any user to access /user-delete
        $response = $this->get('/user-edit');
        $response->assertStatus(302);
        $response->assertRedirect('restricted');
    }
    /***** User Edit End */
}
