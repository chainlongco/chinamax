<?php

namespace Tests\Feature\Feature\Http\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create([
            'name'=>'Admin',
            'description'=>'Administrator role'
        ]);
        $user = User::create([
            'name'=>'Admin Shyu',
            'email'=>'shyuadmin@yahoo.com',
            'password'=>Hash::make('12345678')
        ]);
        $adminRole = DB::table('roles')->select('id')->where('name', 'Admin')->first();
        $user->roles()->attach($adminRole);
    }

    public function test_delete_user_success()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        // After delete, deleteUser method calls -- return $this->listUsers();. Therefore, we expected not data in tbody
        $expected = '';
        $expected .= '~<tbody></tbody>~';
        $this->expectOutputRegex($expected);
        //$controller = new UserController();
        //$response = $controller->listUsers();

        $response = $this->call('GET', '/user-delete', ['id'=>'1']);
        $response->assertStatus(200);
    }

    public function test_delete_user_not_success()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/user-delete', ['id'=>'2']);
        //$response->assertStatus(200);
        $message = $response->json()['msg'];
        $this->assertEquals('Deletion failed.', $message);
    }
}
