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
use App\Http\Controllers\UserController;

class UserListTest extends TestCase
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


    public function test_user_list_form()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/user/list');
        //$response1 = $this->get('/users-list');
        $response->assertSee('My Users');
    }

    public function test_user_list_table_data()
    {
        //$expected ='/Name/i';
        //$this->expectOutputString($expected);
        

        $expected = '';
        $expected .= '~<table class="table table-striped table-hover cell-border" id="usersDatatable" style="padding: 10px;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle text-center">Name</th>
                                <th rowspan="2" class="align-middle text-center">Email</th>
                                <th colspan="4" class="text-center">Roles</th>
                                <th rowspan="2" class="align-middle text-center">Actions</th>
                            </tr>
                            <tr>
                                <th class="text-center">Admin</th>
                                <th class="text-center">Owner</th>
                                <th class="text-center">Manager</th>
                                <th class="text-center">Employee</th>
                            </tr>
                        </thead>~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();
        //dd($response);

        $expected = '';
        $expected .= '~<tbody><tr><td class="align-middle">Admin Shyu</td>~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~<td class="align-middle">shyuadmin@yahoo.com</td>~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~<td class="align-middle text-center"><input type="checkbox" class="roleadmin" id="roleadmin1" style="height:20px; width:20px;" checked></td>~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~<td class="align-middle text-center"><input type="checkbox" class="roleowner" id="roleowner1" style="height:20px; width:20px;" ></td>~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~<td class="align-middle text-center"><input type="checkbox" class="rolemanager" id="rolemanager1" style="height:20px; width:20px;" ></td>~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~<td class="align-middle text-center"><input type="checkbox" class="roleemployee" id="roleemployee1" style="height:20px; width:20px;" ></td>~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~<td><div class="row justify-content-around" style="margin:auto;"><a href="" id="usersave1" class="col-md-5 btn btn-primary usersave" title="Save"><span class="bi bi-save"></span></a>~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~<a href="" id="userdelete1" class="col-md-5 btn btn-danger userdelete" title="Delete"~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~onclick="if(!confirm(~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~Are you sure?~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~)){return false;}~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~<span class="bi-x-lg"></span></a></div></td></tr></tbody>~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();


        $expected = '';
        $expected .= '~<tfoot>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Admin</th>
                                <th class="text-center">Owner</th>
                                <th class="text-center">Manager</th>
                                <th class="text-center">Employee</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </tfoot></table><script>~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~\$\(document\)\.ready\(function\(\)\{~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~\(\"\#usersDatatable\"\).DataTable\(\{~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~scrollCollapse: true,~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~\"columnDefs\": \[\{~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~targets: \[6\],~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();

        $expected = '';
        $expected .= '~orderable: false~';
        $this->expectOutputRegex($expected);
        $controller = new UserController();
        $response = $controller->listUsers();
    }
}
