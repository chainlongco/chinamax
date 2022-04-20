<?php

namespace Tests\Feature\Http\Controllers\Restaurant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\RestaurantController;
use Illuminate\Http\Request;

class AddTest extends TestCase
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
    }

    public function test_add_new_restaurant_form()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        
        $response = $this->get('/restaurant');
        $response->assertSee('Restaurant Information');
        $response->assertSeeInOrder(['Restaurant Information', 'Name', 'Year Founded', 'Tax Rate', 'Phone', 'Email Address', 'We', 'll never share your email with anyone else.', 'Address 1', 'Address 2', 'City', 'State', 'Zip Code', 'Submit', 'Cancel'], $escaped=false);
    }

    public function test_add_new_restaurant_without_any_required_field()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', '/restaurant', ['name'=>'', 'taxrate'=>'']);
        $response->assertStatus(200);

        $errors = $response->json()['error'];
        $this->assertEquals(2, count($errors));
        $this->assertEquals('The name field is required.', $errors['name'][0]);
        $this->assertEquals('The taxrate field is required.', $errors['taxrate'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_add_new_restaurant_with_name_too_long()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', '/restaurant', ['name'=>'123456789012345678901', 'taxrate'=>'0.0825']);
        $response->assertStatus(200);

        $errors = $response->json()['error'];
        $this->assertEquals(1, count($errors));
        $this->assertEquals('The name must not be greater than 20 characters.', $errors['name'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_add_new_restaurant_save_success()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $response = $this->call('POST', '/restaurant', ['name'=>'Chinamax', 'yearfounded'=>'2021', 'taxrate'=>'0.0825', 'phone'=>'8171234567', 'email'=>'shyujacky@gmail.com', 'address1'=>'100 Centry Road', 'address2'=>'Suite 100', 'city'=>'Grapevine', 'state'=>'TX', 'zip'=>'76034']);
        $response->assertStatus(200);

        $message = $response->json()['msg'];
        $this->assertEquals('Restaurant Information has been successfully created.', $message);

        $restaurant = DB::table('restaurants')->first();
        $this->assertEquals('Chinamax', $restaurant->name);
        $this->assertEquals('2021', $restaurant->year_founded);
        $this->assertEquals('0.0825', $restaurant->tax_rate);
        $this->assertEquals('8171234567', $restaurant->phone);
        $this->assertEquals('shyujacky@gmail.com', $restaurant->email);
        $this->assertEquals('100 Centry Road', $restaurant->address1);
        $this->assertEquals('Suite 100', $restaurant->address2);
        $this->assertEquals('Grapevine', $restaurant->city);
        $this->assertEquals('TX', $restaurant->state);
        $this->assertEquals('76034', $restaurant->zip);
    }    

    public function test_add_new_restaurant_save_failed()
    {
        $fakeRequest = Request::create('/', 'GET', ['name'=>'Chinamax', 'taxrate'=>'0.0825', 'phone'=>'2146808281']); //************** Very important fake Request
        $RestaurantControllerTest = new RestaurantControllerTest();
        $response = $RestaurantControllerTest->restaurantSubmit($fakeRequest);
       
        //dd(get_class_methods($response));  //********** Very important way

        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);

        //$content = json_decode($response->content());
        //$status = $content->status;
        $status = $response->getData()->status;
        $this->assertEquals(2, $status);
        
        //$message = $content->msg;
        $message = $response->getData()->msg;
        $this->assertEquals('Create failed', $message);
    }



    public function test_update_existing_restaurant_without_any_required_field()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', '/restaurant', ['id'=>1, 'name'=>'', 'taxrate'=>'']);
        $response->assertStatus(200);

        $errors = $response->json()['error'];
        $this->assertEquals(2, count($errors));
        $this->assertEquals('The name field is required.', $errors['name'][0]);
        $this->assertEquals('The taxrate field is required.', $errors['taxrate'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_update_existing_restaurant_with_name_too_long()
    {
        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('POST', '/restaurant', ['id'=>1, 'name'=>'123456789012345678901', 'taxrate'=>'0.0825']);
        $response->assertStatus(200);

        $errors = $response->json()['error'];
        $this->assertEquals(1, count($errors));
        $this->assertEquals('The name must not be greater than 20 characters.', $errors['name'][0]);

        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
    }

    public function test_update_existing_restaurant_save_success()
    {
        Restaurant::create([
            'name'=>'ChinamaxBefore',
            'tax_rate'=>'0.02',
        ]);

        $restaurant = DB::table('restaurants')->first();
        $this->assertEquals('ChinamaxBefore', $restaurant->name);
        $this->assertEquals('0.02', $restaurant->tax_rate);

        // Log in as administrator to access user list
        $response = $this->post('/login', ['email'=>'shyuadmin@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        $response = $this->call('POST', '/restaurant', ['id'=>1, 'name'=>'Chinamax', 'yearfounded'=>'2021', 'taxrate'=>'0.0825', 'phone'=>'8171234567', 'email'=>'shyujacky@gmail.com', 'address1'=>'100 Centry Road', 'address2'=>'Suite 100', 'city'=>'Grapevine', 'state'=>'TX', 'zip'=>'76034']);
        $response->assertStatus(200);

        $message = $response->json()['msg'];
        $this->assertEquals('Restaurant has been successfully updated.', $message);

        $restaurant = DB::table('restaurants')->first();
        $this->assertEquals('Chinamax', $restaurant->name);
        $this->assertEquals('2021', $restaurant->year_founded);
        $this->assertEquals('0.0825', $restaurant->tax_rate);
        $this->assertEquals('8171234567', $restaurant->phone);
        $this->assertEquals('shyujacky@gmail.com', $restaurant->email);
        $this->assertEquals('100 Centry Road', $restaurant->address1);
        $this->assertEquals('Suite 100', $restaurant->address2);
        $this->assertEquals('Grapevine', $restaurant->city);
        $this->assertEquals('TX', $restaurant->state);
        $this->assertEquals('76034', $restaurant->zip);
    }

    public function test_update_existing_restaurant_save_failed()
    {
        $fakeRequest = Request::create('/', 'GET', ['id'=>1, 'name'=>'Chinamax', 'taxrate'=>'0.0825', 'phone'=>'2146808281']); //************** Very important fake Request
        $RestaurantControllerTest = new RestaurantControllerTest();
        $response = $RestaurantControllerTest->restaurantSubmit($fakeRequest);
       
        //dd(get_class_methods($response));  //********** Very important way

        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);

        //$content = json_decode($response->content());
        //$status = $content->status;
        $status = $response->getData()->status;
        $this->assertEquals(2, $status);
        
        //$message = $content->msg;
        $message = $response->getData()->msg;
        $this->assertEquals('Update failed', $message);
    }
}

class RestaurantControllerTest extends RestaurantController
{
    public function saveNewRestaurant($retaurant)
    {
        return false;
    }

    public function saveExistingRestaurant($request)
    {
        return false;
    }
}