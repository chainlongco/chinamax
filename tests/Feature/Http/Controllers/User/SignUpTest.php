<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        /*Role::create([
            'name'=>'Admin',
            'description'=>'Administrator role'
        ]);*/
        User::create([
            'name'=>'Jacky Shyu',
            'email'=>'shyujacky@yahoo.com',
            'password'=>Hash::make('12345678')
        ]);
        //$adminRole = DB::table('roles')->select('id')->where('name', 'Admin')->first();
        //$user->roles()->attach($adminRole);
    }

    public function test_sign_up_form()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('User Register');
        $response->assertSeeInOrder(['User Register', 'User Name', 'Email Address', 'We', 'll never share your email with anyone else.', 'Password', 'I already have an account, sign in', 'Sign Up']);
        $response->assertSee("We'll never share your email with anyone else.", $escaped = false);
    }

    public function test_sign_up_without_username_email_password()
    {
        $response = $this->call('POST', '/register/submit', ['name'=>'', 'email'=>'', 'password'=>'']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];
        $this->assertEquals(3, count($errors));
        $this->assertEquals('The name field is required.', $errors['name'][0]);
        $this->assertEquals('The email field is required.', $errors['email'][0]);
        $this->assertEquals('The password field is required.', $errors['password'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_up_with_too_long_username()
    {
        $response = $this->call('POST', '/register/submit', ['name'=>'123456789012345678901', 'email'=>'shyujacky@gmail.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];
        //dd($errors)['password'][0];
        //dd($errors);

        $this->assertEquals(1, count($errors));
        $this->assertEquals('The name must not be greater than 20 characters.', $errors['name'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_up_with_duplicate_username()
    {
        $response = $this->call('POST', '/register/submit', ['name'=>'Jacky Shyu', 'email'=>'shyujacky@gmail.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];
        //dd($errors)['password'][0];
        //dd($errors);

        $this->assertEquals(1, count($errors));
        $this->assertEquals('The name has already been taken.', $errors['name'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_up_with_duplicate_email()
    {
        $response = $this->call('POST', '/register/submit', ['name'=>'Jacky Shyu Junior', 'email'=>'shyujacky@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];
        //dd($errors)['password'][0];
        //dd($errors);

        $this->assertEquals(1, count($errors));
        $this->assertEquals('The email has already been taken.', $errors['email'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_up_with_invalid_email()
    {
        $response = $this->call('POST', '/register/submit', ['name'=>'Jacky Shyu Junior', 'email'=>'shyujacky', 'password'=>'12345678']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];
        //dd($errors)['password'][0];
        //dd($errors);

        $this->assertEquals(1, count($errors));
        $this->assertEquals('The email must be a valid email address.', $errors['email'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_up_success()
    {
        $response = $this->post('/register/submit', ['name'=>'Jacky Shyu Junior', 'email'=>'shyujacky@gmail.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $status = $response->json()['status'];
        $this->assertEquals(1, $status);
        
        $message = $response->json()['msg'];
        $this->assertEquals('New User has been successfully registered. Please contact Administrator to assign this new user for access control rights like Order History, Customer Information and User Information.', $message);

        $user = DB::table('users')->where('name', 'Jacky Shyu Junior')->first();
        $this->assertEquals('shyujacky@gmail.com', $user->email);
        $this->assertTrue(Hash::check('12345678', $user->password));

        //dd($user);
    }
}
