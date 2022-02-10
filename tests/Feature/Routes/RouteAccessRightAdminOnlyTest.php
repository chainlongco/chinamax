<?php

namespace Tests\Feature\Routes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RouteAccessRightAdminOnlyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create(['name'=>'Admin', 'description'=>'Administrator role']);
        $managerRole = Role::create(['name'=>'Manager', 'description'=>'Manager role']);
        $employeeRole = Role::create(['name'=>'Employee', 'description'=>'Employee role']);  

        $adminUser = User::create(['name'=>'Admin', 'email'=>'shyuadmin@yahoo.com', 'password'=>Hash::make('12345678')]);
        $adminUser->roles()->attach($adminRole);
        $adminUser->roles()->attach($managerRole);
        $adminUser->roles()->attach($employeeRole);
        
        $ownerUser = User::create(['name'=>'Owner', 'email'=>'shyuowner@yahoo.com', 'password'=>Hash::make('12345678')]);
        $ownerUser->roles()->attach($managerRole);
        $ownerUser->roles()->attach($employeeRole);

        $managerUser = User::create(['name'=>'Manager', 'email'=>'shyumanager@yahoo.com', 'password'=>Hash::make('12345678')]);
        $managerUser->roles()->attach($managerRole);
        $managerUser->roles()->attach($employeeRole);

        $employeeUser = User::create(['name'=>'Employee', 'email'=>'shyuemployee@yahoo.com', 'password'=>Hash::make('12345678')]);
        $employeeUser->roles()->attach($employeeRole);
    }

    public function test_rights_for_get_user_list()
    {
        // Route::get('/user/list', [UserController::class, 'loadUsers']);
        // Without any role
        $response = $this->call('GET', '/user/list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/user/list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/user/list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner with Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/user/list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/user/list');
        $response->assertStatus(200);
        $response->assertSee('My Users');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));
    }

    public function test_rights_for_get_users_list()
    {
        // Route::get('/users-list', [UserController::class, 'listusers']);
        // Without any role
        $response = $this->call('GET', '/users-list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/users-list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/users-list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner with Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/users-list');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $expected = '~yahoo.com~';
        $this->expectOutputRegex($expected);
        $response = $this->get('/users-list');
        $response->assertStatus(200);

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));
    }

    public function test_rights_for_get_user_delete()
    {
        // Route::get('/user-delete', [UserController::class, 'userDelete']);
        // Without any role
        $response = $this->call('GET', '/user-delete');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/user-delete');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/user-delete');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner with Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/user-delete');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $user = DB::table('users')->where('id', 4)->first();
        $this->assertEquals('Employee', $user->name);

        $response = $this->call('GET', '/user-delete', ['id'=>4]);
        $response->assertStatus(200);

        $user = DB::table('users')->where('id', 4)->first();
        $this->assertNull($user);

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));
    }

    public function test_rights_for_get_user_edit()
    {
        // Route::get('/user-edit', [UserController::class, 'userEdit']);
        // Without any role
        $response = $this->call('GET', '/user-edit');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');


        // Employee role
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/user-edit');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyumanager@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/user-edit');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Owner with Manager role
        $response = $this->call('POST', '/login', ['email'=>'shyuowner@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/user-edit');
        $response->assertStatus(302);
        $response->assertRedirect('/restricted');

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));


        // Admin role
        $response = $this->call('POST', '/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/user-edit', ['id'=>4]);
        $response->assertStatus(200);
        $message = $response->json()['msg'];
        $this->assertEquals('The roles of Employee have been updated successfully.', $message);

        $response = $this->get('/logout');
        $response->assertRedirect(route('auth.login'));
    }
}
