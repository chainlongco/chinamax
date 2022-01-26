<?php

namespace Tests\Feature\Routes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RouteAccessRightNoRestrictionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $adminUser = User::create(['name'=>'Admin', 'email'=>'shyuadmin@yahoo.com', 'password'=>Hash::make('12345678')]);

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

    public function test_get_login()
    {
        // Route::get('/login', [UserController::class, 'login'])->name('auth.login');
        $response = $this->call('GET', '/login');
        $response->assertStatus(200);
        $response->assertSee('User Log in');
    }
    
    public function test_get_register()
    {
        // Route::get('/register', [UserController::class, 'register'])->name('auth.register');
        $response = $this->call('GET', '/register');
        $response->assertStatus(200);
        $response->assertSee('User Register');
    }

    public function test_post_login()
    {
        // Route::post('/login', [UserController::class, 'signin'])->name('login-submit');
        $response = $this->call('post', '/login');
        $response->assertStatus(200);
        $response->assertSee('The email field is required.');
    }

    public function test_get_logout()
    {
        // Route::get('/logout', [UserController::class, 'logout']);
        $response = $this->call('POST', '/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/logout');
        $response->assertRedirect(route('auth.login'));
    }

    public function test_post_register_submit()
    {
        // Route::post('/register/submit', [UserController::class, 'signup'])->name('register.submit');
        $response = $this->call('POST', '/register/submit');
        $response->assertStatus(200);
        $response->assertSee('The name field is required.');
    }

    public function test_get_cart()
    {
        // Route::get('/cart', [OrderController::class, 'cart']);
        $response = $this->call('GET', '/cart');
        $response->assertStatus(200);
        $response->assertSee('My Cart');
    }

    public function test_get_cart_quantity()
    {
        // Route::get('/cart-quantity', [OrderController::class, 'cartQuantityUpdated']);
        $response = $this->call('GET', '/cart-quantity');
        $response->assertStatus(500);   // This means it passes the 302 (Redirect to /restricted) which is 'You do not have permission to access this page.'
    }    

    public function test_get_cart_note()
    {
        // Route::get('/cart-note', [OrderController::class, 'cartNote']);
        $response = $this->call('GET', '/cart-note', ['note'=>'Mild spicy']);
        $response->assertStatus(200);
        $note = $response->json()['note'];
        $this->assertEquals('Mild spicy', $note);
    }

    public function test_get_empty_cart()
    {
        // Route::get('/empty-cart', [OrderController::class, 'emptyCart']);
        $response = $this->call('GET', '/empty-cart');
        $response->assertStatus(200);
        $priceDetail = $response->json()['priceDetail'];
        //dd($priceDetail['totalQuantity']);
        $this->assertEquals(0, $priceDetail['totalQuantity']);
    }

    public function test_get_menu()
    {
        // Route::get('/menu', [MenuController::class, 'menu']);
        $response = $this->call('GET', '/menu');
        $response->assertStatus(500);   // This means it passes the 302 (Redirect to /restricted) which is 'You do not have permission to access this page.'
    }

    public function test_order_choices()
    {
        // Route::get('/order-choices', [MenuController::class, 'orderChoices']);
        $response = $this->call('GET', '/order-choices');
        $response->assertStatus(500);   // This means it passes the 302 (Redirect to /restricted) which is 'You do not have permission to access this page.'
    }

    public function test_get_order_added()
    {
        // Route::get('/order-added', [OrderController::class, 'orderAdded']);
        $response = $this->call('GET', '/order-added');
        $response->assertStatus(500);   // This means it passes the 302 (Redirect to /restricted) which is 'You do not have permission to access this page.'
    }
    
    public function test_get_order_edit()
    {
        // Route::get('/order-edit', [OrderController::class, 'orderEditForPopup']);
        $response = $this->call('GET', '/order-edit');
        $response->assertStatus(500);   // This means it passes the 302 (Redirect to /restricted) which is 'You do not have permission to access this page.'
    }

    public function test_get_order_updated()
    {
        // Route::get('/order-updated', [OrderController::class, 'orderUpdated']);
        $response = $this->call('GET', '/order-updated');
        $response->assertStatus(500);   // This means it passes the 302 (Redirect to /restricted) -- You do not have permission to access this page.
    }

    public function test_get_checkout()
    {
        // Route::get('/checkout', function(){
        $response = $this->call('GET', '/checkout');
        $response->assertStatus(200);
        $response->assertSee('Checkout');
        $response->assertSee('Place Order');
    }
    
    public function test_post_checkout()
    {
        // Route::post('/checkout', [OrderController::class, 'checkout'])->name('place-order-submit');
        $response = $this->call('POST', '/checkout');
        $response->assertStatus(200);
        $response->assertSee('The firstname field is required.');
        $response->assertSee('The zip field is required.');
    }

    public function test_get_customer_register()
    {
        // Route::get('/customerRegister', [CustomerController::class, 'customerRegister'])->name('customer-signup');
        $response = $this->call('GET', '/customerRegister');
        $response->assertStatus(200);
        $response->assertSee('Customer Register');
    }

    public function test_post_customer_signup_submit()
    {
        // Route::post('/customerSignup', [CustomerController::class, 'customerSignup'])->name('customer-signup-submit');
        $response = $this->call('POST', '/customerSignup');
        $response->assertStatus(200);
        $response->assertSee('The firstname field is required.');
    }

    public function test_get_customer_login()
    {
        // Route::get('/customerLogin', [CustomerController::class, 'customerLogin'])->name('customer-login');
        $response = $this->call('GET', '/customerLogin');
        $response->assertStatus(200);
        $response->assertSee('Customer Log in');
    }

    public function test_post_customer_login()
    {
        // Route::post('/customerLogin', [CustomerController::class, 'customerSignIn'])->name('customer-login-submit');
        $response = $this->call('POST', '/customerLogin');
        $response->assertStatus(200);
        $response->assertSee('The email field is required.');
    }

    public function test_get_customer_logout()
    {
        // Route::get('/customerLogout', [CustomerController::class, 'customerLogout']);
        $response = $this->call('POST', '/customerLogin', ['email'=>'shyujacky@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);
        
        $response = $this->call('GET', '/customerLogout');
        $response->assertRedirect('/customerLogin');
    }

    public function test_restricted()
    {
        // Route::get('/restricted', function(){
        $response = $this->call('GET', '/restricted');
        $response->assertStatus(200);
        $response->assertSee('You do not have permission to access this page.');

    }
}
