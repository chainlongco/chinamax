<?php

namespace Tests\Feature\Http\Controllers\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;

class AddTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create([
            'name'=>'Admin',
            'description'=>'Administrator role'
        ]);
        /*Role::create([
            'name'=>'Owner',
            'description'=>'Owner role'
        ]);
        Role::create([
            'name'=>'Manager',
            'description'=>'Manager role'
        ]);*/
        $user = User::create([
            'name'=>'Admin Shyu',
            'email'=>'shyuadmin@yahoo.com',
            'password'=>Hash::make('12345678')
        ]);
        $adminRole = DB::table('roles')->select('id')->where('name', 'Admin')->first();
        //$ownerRole = DB::table('roles')->select('id')->where('name', 'Owner')->first();
        //$managerRole = DB::table('roles')->select('id')->where('name', 'Manager')->first();
        $user->roles()->attach($adminRole);
        //$user->roles()->attach($ownerRole);
        //$user->roles()->attach($managerRole);

        Customer::create([
            'first_name'=>'Jacky',
            'last_name'=>'Shyu',
            'email'=>'shyujacky@yahoo.com',
            'password'=>'$2y$04$hP7s3NfMq3Ne7r83MDokIeu0KzX1u8NZIiWRs1RjJDUZgRD2SuUOm',
            'phone'=>'1234567890',
            'address1'=>'100 Centry Road', 
            'address2'=>'Suite 100', 
            'city'=>'Grapevine', 
            'state'=>'TX', 'zip'=>'76051', 
            'card_number'=>'1234567890123456', 
            'expired'=>'1212', 
            'cvv'=>'123'
        ]);
    }

    public function test_add_new_customer_form()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        
        $response = $this->get('/customer/add');
        $response->assertSee('New Customer');
        $response->assertSeeInOrder(['New Customer', 'First Name', 'Last Name', 'Phone', 'Email Address', "We'll never share your email with anyone else.", 'Address 1', 'Address 2', 'City', 'State', 'Zip Code', 'Card Number', 'Expiration Month/Year', 'CVV', 'Submit', 'Cancel'], $escaped=false);
    }

    public function test_add_new_customer_without_any_required_field()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', '/customer/add', ['firstname'=>'', 'lastname'=>'', 'phone'=>'', 'email'=>'', 'address1'=>'', 'address2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'card'=>'', 'expired'=>'', 'cvv'=>'']);
        $response->assertStatus(200);

        $errors = $response->json()['error'];
        $this->assertEquals(3, count($errors));
        $this->assertEquals('The firstname field is required.', $errors['firstname'][0]);
        $this->assertEquals('The lastname field is required.', $errors['lastname'][0]);
        $this->assertEquals('The phone field is required.', $errors['phone'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_add_new_customer_with_first_name_too_long()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', '/customer/add', ['firstname'=>'123456789012345678901', 'lastname'=>'Shyu', 'phone'=>'123456789011', 'email'=>'', 'address1'=>'', 'address2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'card'=>'', 'expired'=>'', 'cvv'=>'']);
        $response->assertStatus(200);

        $errors = $response->json()['error'];
        $this->assertEquals(1, count($errors));
        $this->assertEquals('The firstname must not be greater than 20 characters.', $errors['firstname'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_add_new_customer_with_last_name_too_long()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', '/customer/add', ['firstname'=>'Jacky', 'lastname'=>'123456789012345678901', 'phone'=>'123456789011', 'email'=>'', 'address1'=>'', 'address2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'card'=>'', 'expired'=>'', 'cvv'=>'']);
        $response->assertStatus(200);

        $errors = $response->json()['error'];
        $this->assertEquals(1, count($errors));
        $this->assertEquals('The lastname must not be greater than 20 characters.', $errors['lastname'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_add_new_customer_with_duplicate_phone()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', '/customer/add', ['firstname'=>'Jacky', 'lastname'=>'shyu', 'phone'=>'1234567890', 'email'=>'', 'address1'=>'', 'address2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'card'=>'', 'expired'=>'', 'cvv'=>'']);
        $response->assertStatus(200);

        $errors = $response->json()['error'];
        $this->assertEquals(1, count($errors));
        $this->assertEquals('The phone has already been taken.', $errors['phone'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_add_new_customer_with_duplicate_email()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', '/customer/add', ['firstname'=>'Jacky', 'lastname'=>'shyu', 'phone'=>'123456789011', 'email'=>'shyujacky@yahoo.com', 'address1'=>'', 'address2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'card'=>'', 'expired'=>'', 'cvv'=>'']);
        $response->assertStatus(200);

        $errors = $response->json()['error'];
        $this->assertEquals(1, count($errors));
        $this->assertEquals('The email has already been taken.', $errors['email'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_add_new_customer_save_success()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', '/customer/add', ['firstname'=>'Jacky', 'lastname'=>'Shyu', 'phone'=>'8171234567', 'email'=>'shyujacky@gmail.com', 'address1'=>'100 Centry Road', 'address2'=>'Suite 100', 'city'=>'Grapevine', 'state'=>'TX', 'zip'=>'76034', 'card'=>'1234567890123456', 'expired'=>'1212', 'cvv'=>'123']);
        $response->assertStatus(200);
        
        $status = $response->json()['status'];
        $this->assertEquals(1, $status);

        $message = $response->json()['msg'];
        $this->assertEquals('New Customer has been successfully created.', $message);

        $customer = DB::table('customers')->where('email', 'shyujacky@gmail.com')->first();
        $this->assertEquals('Jacky', $customer->first_name);
        $this->assertEquals('Shyu', $customer->last_name);
        $this->assertEquals('8171234567', $customer->phone);
        $this->assertEquals('shyujacky@gmail.com', $customer->email);
        $this->assertEquals('100 Centry Road', $customer->address1);
        $this->assertEquals('Suite 100', $customer->address2);
        $this->assertEquals('Grapevine', $customer->city);
        $this->assertEquals('TX', $customer->state);
        $this->assertEquals('76034', $customer->zip);
        $this->assertEquals('1234567890123456', $customer->card_number);
        $this->assertEquals('1212', $customer->expired);
        $this->assertEquals('123', $customer->cvv);
    }    

    public function test_add_new_customer_save_failed()
    {
        $fakeRequest = Request::create('/', 'GET', ['firstname'=>'Jacky', 'lastname'=>'Shyu', 'phone'=>'2146808281']); //************** Very important fake Request
        $customerControllerTest = new CustomerControllerTestForAdd();
        $response = $customerControllerTest->createCustomer($fakeRequest);
       
        //dd(get_class_methods($response));  //********** Very important way

        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);

        $content = json_decode($response->content());
        $status = $content->status;
        $this->assertEquals(2, $status);
        
        $message = $content->msg;
        $this->assertEquals('Create failed', $message);
    }
}

class CustomerControllerTestForAdd extends CustomerController
{
    public function saveNewCustomer($customer)
    {
        return false;
    }

    public function saveExistingCustomer($request)
    {
        return false;
    }
}
