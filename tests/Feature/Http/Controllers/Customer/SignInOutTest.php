<?php

namespace Tests\Feature\Http\Controllers\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SignInOutTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Customer::create([
            'first_name'=>'Jacky',
            'last_name'=>'Shyu',
            'email'=>'shyujacky@yahoo.com',
            'password'=>'$2y$04$hP7s3NfMq3Ne7r83MDokIeu0KzX1u8NZIiWRs1RjJDUZgRD2SuUOm',
            'phone'=>'12345678901'
        ]);
    }

    public function test_login_form()
    {
        $response = $this->call('GET', 'customerLogin');
        $response->assertStatus(200);
        $response->assertSee('Customer Log in');
        $response->assertSee('Email address');
        $response->assertSee("We'll never share your email with anyone else.", $escaped=false);
        $response->assertSee('Password');
        $response->assertSeeInOrder(['Customer Log in', 'Email address', "We'll never share your email with anyone else.", 'Password'], $escaped=false);
    }

    public function test_sign_in_without_email_password()
    {
        $response = $this->call('POST', '/customerLogin', ['email'=>'', 'password'=>'']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];
        $this->assertEquals('2', count($errors));
        $this->assertEquals('The email field is required.', $errors['email'][0]);
        $this->assertEquals('The password field is required.', $errors['password'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_in_without_email()
    {
        $response = $this->call('POST', '/customerLogin', ['email'=>'', 'password'=>'12345678']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];
        $this->assertEquals(1, count($errors));
        $this->assertEquals('The email field is required.', $errors['email'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_in_without_password()
    {
        $response = $this->call('POST', '/customerLogin', ['email'=>'shyujacky@yahoo.com', 'password'=>'']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $this->assertEquals(1, count($errors));
        $this->assertEquals('The password field is required.', $errors['password'][0]);
        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_sign_in_with_invalid_email()
    {
        $response = $this->call('POST', '/customerLogin', ['email'=>'shyujacky', 'password'=>'12345678']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $this->assertEquals(1, count($errors));
        $this->assertEquals('The email must be a valid email address.', $errors['email'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_sign_in_email_password_not_match()
    {
        $response = $this->post('/customerLogin', ['email'=>'shyujacky@yahoo.com', 'password'=>'1234567']);
        $response->assertStatus(200);

        $status = $response->json()['status'];
        $this->assertEquals(1, $status);

        $message = $response->json()['msg'];
        $this->assertEquals('Email and Password not matched or you have not sign up yet!', $message);
    }

    public function test_sign_in_success()
    {
        $response = $this->call('POST', '/customerLogin', ['email'=>'shyujacky@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
    
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);

        $customer = Session::get('customer');
        $this->assertEquals('Shyu', $customer->last_name);
        $this->assertEquals('shyujacky@yahoo.com', $customer->email);
        $this->assertTrue(Hash::check('12345678', $customer->password));
    }

    public function test_log_out()
    {
        $response = $this->post('/customerLogin', ['email'=>'shyujacky@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $customer = Session::get('customer');
        $this->assertEquals('Shyu', $customer->last_name);
        $this->assertEquals('shyujacky@yahoo.com', $customer->email);
        $this->assertTrue(Hash::check('12345678', $customer->password));

        $response = $this->get('/customerLogout');
        $customer = Session::get('customer');
        $this->assertNull($customer);
        $response->assertRedirect(route('customer-login'));
    }
}
