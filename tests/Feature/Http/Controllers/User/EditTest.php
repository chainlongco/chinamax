<?php

namespace Tests\Feature\Http\Controllers\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class EditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create([
            'name'=>'Admin',
            'description'=>'Administrator role'
        ]);
        Role::create([
            'name'=>'Manager',
            'description'=>'Manager role'
        ]);
        Role::create([
            'name'=>'Employee',
            'description'=>'Employee role'
        ]);
        $user = User::create([
            'name'=>'Admin Shyu',
            'email'=>'shyuadmin@yahoo.com',
            'password'=>Hash::make('12345678')
        ]);
        $adminRole = DB::table('roles')->select('id')->where('name', 'Admin')->first();
        $user->roles()->attach($adminRole);
    }

    public function test_edit_user_success()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/user-edit', ['id'=>'1', 'admin'=>'true', 'manager'=>'true', 'employee'=>'true']);
        $message = $response->json()['msg'];
        $this->assertEquals('The roles of Admin Shyu have been updated successfully.', $message);
    }
}
