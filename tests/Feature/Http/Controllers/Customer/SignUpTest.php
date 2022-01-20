<?php

namespace Tests\Feature\Http\Controllers\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
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
   
    public function test_sign_up_form()
    {
        $response = $this->get('/customerRegister');
        $response->assertStatus(200);
        $response->assertSee('Customer Register');
        $response->assertSeeInOrder(['Customer Register', 'First Name', 'Last Name', 'Phone', 'Email Address', "We'll never share your email with anyone else.", 'Password', 'Sign Up'], $escaped=false);
    }

    public function test_sign_up_without_any_field()
    {
        $response = $this->call('POST', '/customerSignup', ['firstname'=>'', 'lastname'=>'', 'phone'=>'', 'email'=>'', 'password'=>'']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];
        $this->assertEquals(5, count($errors));
        $this->assertEquals(0, $status);

        $firstNameError = $errors['firstname'][0];
        $this->assertEquals('The firstname field is required.', $firstNameError);

        $lastNameError = $errors['lastname'][0];
        $this->assertEquals('The lastname field is required.', $lastNameError);

        $phoneError = $errors['phone'][0];
        $this->assertEquals('The phone field is required.', $phoneError);

        $emailError = $errors['email'][0];
        $this->assertEquals('The email field is required.', $emailError);

        $passwordError = $errors['password'][0];
        $this->assertEquals('The password field is required.', $passwordError);
    }

    public function test_sign_up_with_too_long_first_name()
    {
        $response = $this->call('POST', '/customerSignup', ['firstname'=>'123456789012345678901', 'lastname'=>'Shyu', 'phone'=>'1234567891', 'email'=>'shyujacky1@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];

        $this->assertEquals(1, count($errors));
        $this->assertEquals('The firstname must not be greater than 20 characters.', $errors['firstname'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_up_with_too_long_last_name()
    {
        $response = $this->call('POST', '/customerSignup', ['firstname'=>'Jacky', 'lastname'=>'123456789012345678901', 'phone'=>'1234567891', 'email'=>'shyujacky1@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];

        $this->assertEquals(1, count($errors));
        $this->assertEquals('The lastname must not be greater than 20 characters.', $errors['lastname'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_up_with_invalid_email()
    {
        $response = $this->call('POST', '/customerSignup', ['firstname'=>'Jacky', 'lastname'=>'Shyu', 'phone'=>'1234567891', 'email'=>'shyujacky', 'password'=>'12345678']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];

        $this->assertEquals(1, count($errors));
        $this->assertEquals('The email must be a valid email address.', $errors['email'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_up_with_duplicate_email()
    {
        $response = $this->call('POST', '/customerSignup', ['firstname'=>'Jacky', 'lastname'=>'Shyu', 'phone'=>'1234567891', 'email'=>'shyujacky@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $errors = $response->json()['error'];
        $status = $response->json()['status'];

        $this->assertEquals(1, count($errors));
        $this->assertEquals('The email has already been taken.', $errors['email'][0]);
        $this->assertEquals(0, $status);
    }

    public function test_sign_up_success()
    {
        $response = $this->call('POST', '/customerSignup', ['firstname'=>'Jacky1', 'lastname'=>'Shyu1', 'phone'=>'1234567891', 'email'=>'shyujacky@gmail.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $status = $response->json()['status'];
        $this->assertEquals(1, $status);
        
        $message = $response->json()['msg'];
        $this->assertEquals('New Customer has been successfully signed up.', $message);

        $customer = DB::table('customers')->where('email', 'shyujacky@gmail.com')->first();
        $this->assertEquals('Jacky1', $customer->first_name);
        $this->assertEquals('Shyu1', $customer->last_name);
        $this->assertTrue(Hash::check('12345678', $customer->password));

        //dd($user);
    }
}
