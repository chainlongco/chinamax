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

class EditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create(['name'=>'Admin', 'description'=>'Administrator role']);
        $managerRole = Role::create(['name'=>'Manager', 'description'=>'Manager role']);
        $employeeRole = Role::create(['name'=>'Employee', 'description'=>'Employee role']);  

        $user = User::create(['name'=>'Admin Shyu', 'email'=>'shyuadmin@yahoo.com', 'password'=>Hash::make('12345678')]);
        $user->roles()->attach($adminRole);
        $user->roles()->attach($managerRole);
        $user->roles()->attach($employeeRole);

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

    public function test_update_existing_customer_when_customer_not_exists()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/customer/edit/2', ['firstname'=>'Jacky', 'lastname'=>'Shyu', 'phone'=>'12345678901', 'email'=>'shyujacky@yahoo.com', 'address1'=>'', 'address2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'card'=>'', 'expired'=>'', 'cvv'=>'']);
        $response->assertStatus(302);
        $response->assertRedirect(route('customer-add'));
    }

    public function test_update_existing_customer_form()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/customer/edit/1', ['firstname'=>'', 'lastname'=>'', 'phone'=>'', 'email'=>'', 'address1'=>'', 'address2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'card'=>'', 'expired'=>'', 'cvv'=>'']);
        $response->assertStatus(200);
        $response->assertSee('Edit Customer');
        $response->assertSeeInOrder(['Edit Customer', 'First Name', 'Jacky', 'Last Name', 'Shyu', 'Phone', '123-456-7890', 'Email Address', 'shyujacky@yahoo.com', "We'll never share your email with anyone else.", 'Address 1', '100 Centry Road', 'Address 2', 'Suite 100', 'City', 'Grapevine', 'State', 'TX', 'Zip Code', '76051', 'Card Number', '1234-5678-9012-3456', 'Expiration Month/Year', '12/12', 'CVV', '123', 'Submit', 'Cancel'], $escaped=false);
    }

    public function test_update_existing_customer_without_any_required_field()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', route('customer-submit'), ['id'=>1, 'firstname'=>'', 'lastname'=>'', 'phone'=>'', 'email'=>'', 'address1'=>'', 'address2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'card'=>'', 'expired'=>'', 'cvv'=>'']);
        $response->assertStatus(200);

        $errors = $response->json()['error'];
        $this->assertEquals(3, count($errors));
        
        $message = $errors['firstname'][0];
        $this->assertEquals('The firstname field is required.', $message);
        
        $message = $errors['lastname'][0];
        $this->assertEquals('The lastname field is required.', $message);

        $message = $errors['phone'][0];
        $this->assertEquals('The phone field is required.', $message);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_update_existing_customer_first_name_too_long()
    {
       // Log in as administrator to access user list
       $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
       $response->assertStatus(200);

       $response = $this->call('POST', route('customer-submit'), ['id'=>1, 'firstname'=>'123456789012345678901', 'lastname'=>'Shyu', 'phone'=>'1234567890', 'email'=>'', 'address1'=>'', 'address2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'card'=>'', 'expired'=>'', 'cvv'=>'']);
       $response->assertStatus(200);

       $errors = $response->json()['error'];
       $this->assertEquals(1, count($errors));
       $this->assertEquals('The firstname must not be greater than 20 characters.', $errors['firstname'][0]);

       $status = $response->json()['status'];
       $this->assertEquals(0, $status);
    }

    public function test_update_existing_customer_last_name_too_long()
    {
       // Log in as administrator to access user list
       $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
       $response->assertStatus(200);

       $response = $this->call('POST', route('customer-submit'), ['id'=>1, 'firstname'=>'Jacky', 'lastname'=>'123456789012345678901', 'phone'=>'1234567890', 'email'=>'', 'address1'=>'', 'address2'=>'', 'city'=>'', 'state'=>'', 'zip'=>'', 'card'=>'', 'expired'=>'', 'cvv'=>'']);
       $response->assertStatus(200);

       $errors = $response->json()['error'];
       $this->assertEquals(1, count($errors));
       $this->assertEquals('The lastname must not be greater than 20 characters.', $errors['lastname'][0]);

       $status = $response->json()['status'];
       $this->assertEquals(0, $status);
    }
    
    public function test_update_exist_customer_save_success()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', route('customer-submit'), ['id'=>1, 'firstname'=>'Jacky', 'lastname'=>'Shyu', 'phone'=>'2146808281', 'email'=>'shyujacky@gmail.com', 'address1'=>'100 Centry Road updated', 'address2'=>'Suite 100 updated', 'city'=>'Grapevine updated', 'state'=>'CA', 'zip'=>'76051', 'card'=>'1234567890123457', 'expired'=>'1111', 'cvv'=>'111']);
        $response->assertStatus(200);
        
        $status = $response->json()['status'];
        $this->assertEquals(1, $status);

        $message = $response->json()['msg'];
        $this->assertEquals('Existing customer has been successfully updated.', $message);

        $customer = DB::table('customers')->where('email', 'shyujacky@gmail.com')->first();
        $this->assertEquals('Jacky', $customer->first_name);
        $this->assertEquals('Shyu', $customer->last_name);
        $this->assertEquals('2146808281', $customer->phone);
        $this->assertEquals('shyujacky@gmail.com', $customer->email);
        $this->assertEquals('100 Centry Road updated', $customer->address1);
        $this->assertEquals('Suite 100 updated', $customer->address2);
        $this->assertEquals('Grapevine updated', $customer->city);
        $this->assertEquals('CA', $customer->state);
        $this->assertEquals('76051', $customer->zip);
        $this->assertEquals('1234567890123457', $customer->card_number);
        $this->assertEquals('1111', $customer->expired);
        $this->assertEquals('111', $customer->cvv);
    } 

    public function test_update_existing_customer_failed()
    {
        $request = Request::create('/', 'POST', ['id'=>1, 'firstname'=>'Jacky', 'lastname'=>'Shyu', 'phone'=>'1234567890']);
        $customerControllerTest = new CustomerControllerTestForEdit();
        $response = $customerControllerTest->createUpdateCustomer($request);

        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);

        $content = json_decode($response->content());
        $status = $content->status;
        $this->assertEquals(2, $status);
        
        $message = $content->msg;
        $this->assertEquals('Update failed', $message);
    }

    public function test_update_exist_customer_for_expired()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', route('customer-submit'), ['id'=>1, 'firstname'=>'Jacky', 'lastname'=>'Shyu', 'phone'=>'2146808281', 'email'=>'shyujacky@gmail.com', 'address1'=>'100 Centry Road updated', 'address2'=>'Suite 100 updated', 'city'=>'Grapevine updated', 'state'=>'CA', 'zip'=>'76051', 'card'=>'1234567890123457', 'expired'=>'', 'cvv'=>'111']);
        $response->assertStatus(200);
        
        $status = $response->json()['status'];
        $this->assertEquals(1, $status);

        $message = $response->json()['msg'];
        $this->assertEquals('Existing customer has been successfully updated.', $message);

        $customer = DB::table('customers')->where('email', 'shyujacky@gmail.com')->first();
        $this->assertEquals('Jacky', $customer->first_name);
        $this->assertEquals('Shyu', $customer->last_name);
        $this->assertEquals('2146808281', $customer->phone);
        $this->assertEquals('shyujacky@gmail.com', $customer->email);
        $this->assertEquals('100 Centry Road updated', $customer->address1);
        $this->assertEquals('Suite 100 updated', $customer->address2);
        $this->assertEquals('Grapevine updated', $customer->city);
        $this->assertEquals('CA', $customer->state);
        $this->assertEquals('76051', $customer->zip);
        $this->assertEquals('1234567890123457', $customer->card_number);
        $this->assertEquals(null, $customer->expired);
        $this->assertEquals('111', $customer->cvv);
    } 
}

class CustomerControllerTestForEdit extends CustomerController
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
