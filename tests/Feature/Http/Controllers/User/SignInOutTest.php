<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SignInOutTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        User::create([
            'name'=>'Jacky Shyu',
            'email'=>'shyujacky@yahoo.com',
            'password'=>Hash::make('12345678')
        ]);
    }

    // ****Log In Start****
    public function test_login_form()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('User Log in');
        //dd($response);
        // Only test Log in page
        $emailDescription = "We'll never share your email with anyone else.";
        $response->assertSee($emailDescription, $escaped = false);
        $createNew = "I don't have an account, create new";
        $response->assertSee($createNew, $escaped = false);
        $response->assertSeeInOrder(["User Log in", "Email address", "ll never share your email with anyone else.", "Password", "I don", "t have an account, create new", "Sign In"]);
    }

    public function test_sign_in_without_email_password()
    {
        //$response = $this->post('/login', ['email'=>'', 'password'=>'']);
        $response = $this->call('POST', '/login', ['email'=>'', 'password'=>'']);
        $response->assertStatus(200);
        //$response->assertJson([
        //    'error'=>array(0=>'The password field is required.',)
        //]);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];
        //dd($errors)['password'][0];
        //dd($errors);

        $this->assertEquals(2, count($errors));
        $this->assertEquals('The email field is required.', $errors['email'][0]);
        $this->assertEquals('The password field is required.', $errors['password'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_in_without_email()
    {
        //$response = $this->post('/login', ['email'=>'', 'password'=>'12345678']);
        $response = $this->call('POST', '/login', ['email'=>'', 'password'=>'12345678']);
        $response->assertStatus(200);
        //$response->assertJson([
        //    'error'=>array(0=>'The password field is required.',)
        //]);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];
        //dd($errors)['password'][0];
        //dd($errors);

        $this->assertEquals(1, count($errors));
        $this->assertEquals('The email field is required.', $errors['email'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_in_without_password()
    {
        //$response = $this->post('/login', ['email'=>'shyujacky@yahoo.com', 'password'=>'']);
        $response = $this->call('POST', '/login', ['email'=>'shyujacky@yahoo.com', 'password'=>'']);
        $response->assertStatus(200);
        //$response->assertJson([
        //    'error'=>array(0=>'The password field is required.',)
        //]);
        $errors = $response->json()['error'];
        $this->assertEquals(1, count($errors));
        $this->assertEquals('The password field is required.', $errors['password'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
        //dd($errors)['password'][0];
        //dd($errors);
    }

    public function test_sign_in_with_invalid_email()
    {
        $response = $this->call('POST', '/login', ['email'=>'shyujacky', 'password'=>'12345678']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $this->assertEquals(1, count($errors));
        $this->assertEquals('The email must be a valid email address.', $errors['email'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
        //dd($errors)['password'][0];
        //dd($errors);
    }


    public function test_sign_in_email_password_not_match()
    {
        $response = $this->post('/login', ['email'=>'shyujacky@yahoo.com', 'password'=>'1234567']);
        $response->assertStatus(200);

        $status = $response->json()['status'];
        $this->assertEquals(1, $status);

        $message = $response->json()['msg'];
        $this->assertEquals('Email and Password not matched!', $message);
        
        //dd($response->json());
    }

    public function test_sign_in_success()
    {
        $response = $this->post('/login', ['email'=>'shyujacky@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        //Session::put('user', $user);
        $user = Session::get('user');
        $this->assertEquals('Jacky Shyu', $user->name);
        $this->assertEquals('shyujacky@yahoo.com', $user->email);
        $this->assertTrue(Hash::check('12345678', $user->password));
        //dd($user);

    }
    // ****Log In End****

    // ****Log Out Start****
    public function test_log_out()
    {
        $response = $this->post('/login', ['email'=>'shyujacky@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $user = Session::get('user');
        $this->assertEquals('Jacky Shyu', $user->name);
        $this->assertEquals('shyujacky@yahoo.com', $user->email);
        $this->assertTrue(Hash::check('12345678', $user->password));

        $response = $this->get('/logout');
        $user = Session::get('user');
        $this->assertNull($user);
        $response->assertRedirect(route('auth.login'));
    }
    // ****Log Out End****
}
