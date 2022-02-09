<?php

namespace Tests\Feature\Http\Controllers\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Single;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Shared\Cart;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        DB::table('menus')->insert([
            ['name'=>'Appetizers',
                'description'=>'A small dish before main meal',
                'level'=>'0'],
            ['name'=>'Drinks',
                'description'=>'Water, Fresh Juice, Soft Drinks...',
                'level'=>'0'],
            ['name'=>'Combo',
                'description'=>'Side & Entree combination',
                'level'=>'1'],
            ['name'=>'Individual Side/Entree',
                'description'=>'Side or Entree only',
                'level'=>'1']
        ]);

        DB::table('products')->insert([
            ['name'=>'Egg Roll (5)',
                'price'=>'4.59',
                'description'=>'5 egg rolls',
                'gallery'=>'EggRoll.jpg',
                'menu_id'=>'1',
                'category'=>''],
            ['name'=>'Crab Rangoon (6)',
                'price'=>'3.99',
                'description'=>'6 crab rangoons',
                'gallery'=>'CrabRangoon.jpg',
                'menu_id'=>'1',
                'category'=>''],
            ['name'=>'Fried Dumpling (5)',
                'price'=>'3.95',
                'description'=>'5 fried dumplings',
                'gallery'=>'FriedDumpling.jpg',
                'menu_id'=>'1',
                'category'=>''],
            ['name'=>'Water',
                'price'=>'0.00',
                'description'=>'A cup of water',
                'gallery'=>'',
                'menu_id'=>'2',
                'category'=>'Water'],
            ['name'=>'Bottle Water',
                'price'=>'1.50',
                'description'=>'Bottle water',
                'gallery'=>'',
                'menu_id'=>'2',
                'category'=>'Bottle Water'], 
            ['name'=>'Canned Soft Drink',
                'price'=>'1.25',
                'description'=>'Soft drink canned',
                'gallery'=>'',
                'menu_id'=>'2',
                'category'=>'Canned Drink'],
            ['name'=>'Fountain Soft Drink Small',
                'price'=>'1.59',
                'description'=>'Small size fountain soft drink',
                'gallery'=>'',
                'menu_id'=>'2',
                'category'=>'Fountain Drink'],
            ['name'=>'Fountain Soft Drink Medium',
                'price'=>'1.89',
                'description'=>'Medium size fountain soft drink',
                'gallery'=>'',
                'menu_id'=>'2',
                'category'=>'Fountain Drink'],
            ['name'=>'Fountain Soft Drink Large',
                'price'=>'2.19',
                'description'=>'Large size fountain soft drink',
                'gallery'=>'',
                'menu_id'=>'2',
                'category'=>'Fountain Drink'],    
            ['name'=>'Small Fresh Fruit Juice',
                'price'=>'3.99',
                'description'=>'Small size fresh fruit juice',
                'gallery'=>'',
                'menu_id'=>'2',
                'category'=>'Fresh Juice'],
            ['name'=>'Regular Fresh Fruit Juice',
                'price'=>'4.99',
                'description'=>'Regular size fresh fruit juice',
                'gallery'=>'',
                'menu_id'=>'2',
                'category'=>'Fresh Juice'],
            ['name'=>'Small Platter',
                'price'=>'6.40',
                'description'=>'Any 1 side & 1 entree',
                'gallery'=>'SmallPlatter.jpg',
                'menu_id'=>'3',
                'category'=>''],      
            ['name'=>'Regular Platter',
                'price'=>'7.58',
                'description'=>'Any 1 side & 2 entrees',
                'gallery'=>'RegularPlatter.jpg',
                'menu_id'=>'3',
                'category'=>''],
            ['name'=>'Large Platter',
                'price'=>'8.93',
                'description'=>'Any 1 side & 3 entrees',
                'gallery'=>'LargePlatter.jpg',
                'menu_id'=>'3',
                'category'=>''],
            ['name'=>'Party Tray',
                'price'=>'23.99',
                'description'=>'3 sides & 3 large entrees',
                'gallery'=>'PartyTray.jpg',
                'menu_id'=>'3',
                'category'=>''],
            ['name'=>"Kid's Meal",
                'price'=>'4.99',
                'description'=>'One small drink, one side and one entree',
                'gallery'=>'KidsMeal.jpg',
                'menu_id'=>3,
                'category'=>''],    
            ['name'=>'Small Side',
                'price'=>'2.49',
                'description'=>'Small size of side',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Side'],
            ['name'=>'Regular Side',
                'price'=>'2.99',
                'description'=>'Regular size of side',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Side'],
            ['name'=>'Large Side',
                'price'=>'3.49',
                'description'=>'Large size of side',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Side'],    
            ['name'=>'Small Chicken',
                'price'=>'5.49',
                'description'=>'Small size of chicken entree',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Chicken'], 
            ['name'=>'Regular Chicken',
                'price'=>'5.99',
                'description'=>'Regular size of chicken entree',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Chicken'],
            ['name'=>'Large Chicken',
                'price'=>'6.49',
                'description'=>'Large size of chicken entree',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Chicken'],          
            ['name'=>'Small Beef',
                'price'=>'5.99',
                'description'=>'Small size of beef entree',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Beef'],
            ['name'=>'Regular Beef',
                'price'=>'6.49',
                'description'=>'Regular size of beef entree',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Beef'],
            ['name'=>'Large Beef',
                'price'=>'6.99',
                'description'=>'Small size of beef entree',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Beef'],
            ['name'=>'Small Shrimp',
                'price'=>'6.49',
                'description'=>'Small size of shrimp entree',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Shrimp'],
            ['name'=>'Regular Shrimp',
                'price'=>'6.99',
                'description'=>'Regular size of shrimp entree',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Shrimp'],
            ['name'=>'Large Shrimp',
                'price'=>'7.49',
                'description'=>'Large size of shrimp entree',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Shrimp'], 
        ]);

        DB::table('singles')->insert([
            ['name'=>'Side', 'description'=>'Select different size of side'],
            ['name'=>'Chicken Entree', 'description'=>'Select different size of chicken entree'],
            ['name'=>'Beef Entree', 'description'=>'Select different size of beef entree'],
            ['name'=>'Shrimp Entree', 'description'=>'Select different size of shrimp entree']
        ]);

        DB::table('sides')->insert([
            ['name'=>'Fried Rice', 
                'description'=>'Fried rice with some vegetable and soy source',
                'gallery'=>'FriedRice.jpg'],
            ['name'=>'Chow Mein',
                'description'=>'Chow mein with some vegetable',
                'gallery'=>'ChowMein.jpg'],
            ['name'=>'Steam White Rice',
                'description'=>'Plain steam white rice',
                'gallery'=>'SteamWhiteRice.jpg']
        ]);

        DB::table('entrees')->insert([
            ['name'=>'BBQ Chicken',
                'description'=>'BBQ chicken entree',
                'category'=>'Chicken',
                'gallery'=>'BBQChicken.jpg'],
            ['name'=>'Black Pepper Chicken',
                'description'=>'Black pepper chicken entree',
                'category'=>'Chicken',
                'gallery'=>'BlackPepperChicken.jpg'],
            ['name'=>'General Taos Chicken',
                'description'=>'General Taos chicken entree',
                'category'=>'Chicken',
                'gallery'=>'GeneralTaosChicken.jpg'],
            ['name'=>'Jalapeno Chicken',
                'description'=>'Jalapeno chicken entree',
                'category'=>'Chicken',
                'gallery'=>'JalapenoChicken.jpg'],
            ['name'=>'Kung Pao Chicken',
                'description'=>'Kung pao chicken entree',
                'category'=>'Chicken',
                'gallery'=>'KungPaoChicken.jpg'],
            ['name'=>'Mushroom Chicken',
                'description'=>'Mushroom chicken entree',
                'category'=>'Chicken',
                'gallery'=>'MushroomChicken.jpg'],
            ['name'=>'Orange Chicken',
                'description'=>'Orange chicken entree',
                'category'=>'Chicken',
                'gallery'=>'OrangeChicken.jpg'],
            ['name'=>'String Bean Chicken',
                'description'=>'String bean chicken entree',
                'category'=>'Chicken',
                'gallery'=>'StringBeanChicken.jpg'],
            ['name'=>'Teriyaki Chicken',
                'description'=>'Teriyaki chicken entree',
                'category'=>'Chicken',
                'gallery'=>'TeriyakiChicken.jpg'],
            ['name'=>'Beef Broccoli',
                'description'=>'Beef broccoli entree',
                'category'=>'Beef',
                'gallery'=>'BeefBroccoli.jpg'],
            ['name'=>'Hunan Beef',
                'description'=>'Hunan beef entree',
                'category'=>'Beef',
                'gallery'=>'HunanBeef.jpg'],
            ['name'=>'Pepper Steak',
                'description'=>'Pepper steak entree',
                'category'=>'Beef',
                'gallery'=>'PepperSteak.jpg'],
            ['name'=>'Broccoli Shrimp',
                'description'=>'Broccoli shrimp entree',
                'category'=>'Shrimp',
                'gallery'=>'BroccoliShrimp.jpg'],
            ['name'=>'Kung Pao Shrimp',
                'description'=>'Kung pao shrimp entree',
                'category'=>'Shrimp',
                'gallery'=>'KungPaoShrimp.jpg']
        ]);

        DB::table('drinks')->insert([
            ['name'=>'Water', 'description'=>"A cup of water", 'gallery'=>'Water.jpg', 'tablename'=>''],
            ['name'=>'Bottle Water', 'description'=>'Bottle of water', 'gallery'=>'BottleWater.jpg', 'tablename'=>''],
            ['name'=>'Canned Drink', 'description'=>'A canned soft drink', 'gallery'=>'SoftDrinkCan.jpg', 'tablename'=>'cans'],
            ['name'=>'Fountain Drink', 'description'=>'Different size of fountain soft drink', 'gallery'=>'SoftDrinkFountain.jpg', 'tablename'=>'fountains'],
            ['name'=>'Fresh Juice', 'description'=>'Different size of fresh juice', 'gallery'=>'FreshJuice.jpg', 'tablename'=>'juices']
        ]);

        DB::table('combos')->insert([
            ['product_id'=>12, 'side'=>1, 'entree'=>1, 'drink'=>0],
            ['product_id'=>13, 'side'=>1, 'entree'=>2, 'drink'=>0],
            ['product_id'=>14, 'side'=>1, 'entree'=>3, 'drink'=>0],
            ['product_id'=>15, 'side'=>3, 'entree'=>3, 'drink'=>0],
            ['product_id'=>16, 'side'=>1, 'entree'=>1, 'drink'=>1],
        ]);

        DB::table('combodrinks')->insert([
            ['name'=>'Small Drink', 'description'=>"Small fountain drink for kid's meal", 'price'=>0, 'gallery'=>'SoftDrinkFountain.jpg', 'tablename'=>'fountains'],
            ['name'=>'Bottle Water', 'description'=>"Bottle water for kid's meal", 'price'=>0.75, 'gallery'=>'BottleWater.jpg', 'tablename'=>''],
        ]);

        DB::table('cans')->insert([
            ['name'=>"Coke"], ['name'=>"Diet Coke"], ['name'=>"Sprite"], ['name'=>"Dr Pepper"]
        ]);
        
        DB::table('fountains')->insert([
            ['name'=>'Coke'], ['name'=>'Diet Coke'], ['name'=>'Coke Zero'], ['name'=>'Root Beer'], ['name'=>'Fruitopia'], ['name'=>'Nestea'], ['name'=>'Sprite'], ['name'=>'Fanta']
        ]);

        DB::table('juices')->insert([
            ['name'=>'Orange'], ['name'=>'Kiwi'], ['name'=>'Watermelon'], ['name'=>'Strawberry']
        ]);

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

    public function test_checkout_require_fields()
    {
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $response = $this->call('GET', '/order-added', ['productId'=>20, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('POST', '/checkout', []);
        //dd($response->json());
        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
        $errors = $response->json()['error'];
        $this->assertEquals('The firstname field is required.', $errors['firstname'][0]);
        $this->assertEquals('The lastname field is required.', $errors['lastname'][0]);
        $this->assertEquals('The phone field is required.', $errors['phone'][0]);
        $this->assertEquals('The email field is required.', $errors['email'][0]);
        $this->assertEquals('The zip field is required.', $errors['zip'][0]);
        $this->assertEquals('The card field is required.', $errors['card'][0]);
        $this->assertEquals('The expired field is required.', $errors['expired'][0]);
        $this->assertEquals('The cvv field is required.', $errors['cvv'][0]);
    }

    public function test_checkout_first_last_names_too_long()
    {
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $response = $this->call('GET', '/order-added', ['productId'=>20, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('POST', '/checkout', [
            'firstname'=>'123456789012345678901',
            'lastname'=>'123456789012345678901',
            'phone'=>'2146808281',
            'email'=>'shyujacky',
            'zip'=>'76034',
            'card'=>'1234567890123456',
            'expired'=>'2212',
            'cvv'=>'123'
        ]);
        //dd($response->json());
        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
        $errors = $response->json()['error'];
        $this->assertEquals('The firstname must not be greater than 20 characters.', $errors['firstname'][0]);
        $this->assertEquals('The lastname must not be greater than 20 characters.', $errors['lastname'][0]);
        $this->assertEquals('The email must be a valid email address.', $errors['email'][0]);
    }

    public function test_checkout()
    {
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $response = $this->call('GET', '/order-added', ['productId'=>20, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('POST', '/checkout', [
            'firstname'=>'Jacky',
            'lastname'=>'Shyu',
            'phone'=>'2146808281',
            'email'=>'shyujacky@yahoo.com',
            'zip'=>'76034',
            'card'=>'1234567890123456',
            'expired'=>'2212',
            'cvv'=>'123'
        ]);
        //dd($response->json());
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);
        $message = $response->json()['msg'];
        $this->assertEquals('Your order has been submitted succussfully.', $message);
        
        // $orderIdNew = $this->saveOrderTable($customerId, $totalQuantity, $totalPrice, $note, $created);
        $order = DB::table('orders')->where('id', 1)->first();
        $this->assertEquals(1, $order->customer_id);
        $this->assertEquals(1, $order->quantity);
        $this->assertEquals('5.49', $order->total);
    }

    public function test_checkout_with_existing_order_in_databse()
    {
        $employeeRole = Role::create(['name'=>'Employee','description'=>'Employee role']);
        $employeeUser = User::create(['name'=>'Employee Only', 'email'=>'shyuemployee@yahoo.com', 'password'=>Hash::make('12345678')]);
        $employeeUser->roles()->attach($employeeRole);

        Order::create([
            'customer_id'=>1,
            'quantity'=>3,
            'total'=>'13.77',
            'note'=>'Extra soy source'
        ]);

        DB::table('order_products')->insert([
            'order_id'=>1,
            'product_id'=>1,
            'quantity'=>3,
            'summary'=>'Egg Roll (5) (5 egg rolls $4.59)'
        ]);

        // Log in as employee
        $response = $this->post('/login', ['email'=>'shyuemployee@yahoo.com', 'password'=>'12345678']);
        $response->assertStatus(200);

        $response = $this->get('/order/edit/1');
        $response->assertStatus(200);
        $this->assertTrue(Session::has('cart'));
        //dd(Session::get('cart'));

        $response = $this->call('POST', '/checkout', [
            'firstname'=>'Jacky',
            'lastname'=>'Shyu',
            'phone'=>'2146808281',
            'email'=>'shyujacky@yahoo.com',
            'zip'=>'76034',
            'card'=>'1234567890123456',
            'expired'=>'2212',
            'cvv'=>'123'
        ]);
        //dd($response->json());
        $status = $response->json()['status'];
        $this->assertEquals(1, $status);
        $message = $response->json()['msg'];
        $this->assertEquals('Your order has been submitted succussfully.', $message);
        $editOrder = $response->json()['editOrder'];
        $this->assertEquals(true, $editOrder);
        
        // $orderIdNew = $this->saveOrderTable($customerId, $totalQuantity, $totalPrice, $note, $created);
        $order = DB::table('orders')->where('id', 2)->first();
        $this->assertEquals(1, $order->customer_id);
        $this->assertEquals(3, $order->quantity);
        $this->assertEquals('13.77', $order->total);

        //dd($response->getData()->msg);
    }

    public function test_checkout_exception()
    {
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $response = $this->call('GET', '/order-added', ['productId'=>20, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $fakeRequest = Request::create('/', 'POST', [
            'firstname'=>'Jacky',
            'lastname'=>'Shyu',
            'phone'=>'2146808281',
            'email'=>'shyujacky@yahoo.com',
            'zip'=>'76034',
            'card'=>'1234567890123456',
            'expired'=>'2212',
            'cvv'=>'123'
        ]); //************** Very important fake Request
        $controller = new OrderControllerTestForCheckout();
        $response = $controller->checkout($fakeRequest);
        // ***** Note: In this throw exception case, the response is returned the Illuminate\Http\JsonResponse. It is different from all the other regular response: Illuminate\Testing\TestResponse
        // Therefore, we need to use different way to get information: $response->getData()->status , the $response->json() not working *******
        // From now on, we should use $response->getData() for both Illuminate\Http\JsonResponse and Illuminate\Testing\TestResponse
        //dd($response->getData());
        $status = $response->getData()->status;
        $this->assertEquals(3, $status);
        $message = $response->getData()->msg;
        $this->assertEquals('Test Exception', $message);
   }

   public function test_retrieveCustomerId_customer_not_in_session_and_not_existing_in_database()
   {
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $response = $this->call('GET', '/order-added', ['productId'=>20, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('POST', '/checkout', [
            'firstname'=>'JackyNew',
            'lastname'=>'ShyuNew',
            'phone'=>'2146808281',
            'email'=>'shyujackyNew@yahoo.com',
            'zip'=>'76034',
            'card'=>'1234567890123456',
            'expired'=>'2212',
            'cvv'=>'123'
        ]);
        //dd($response->json());
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);
        $message = $response->json()['msg'];
        $this->assertEquals('Your order has been submitted succussfully.', $message);
        
        // $orderIdNew = $this->saveOrderTable($customerId, $totalQuantity, $totalPrice, $note, $created);
        $order = DB::table('orders')->where('id', 1)->first();
        $this->assertEquals(2, $order->customer_id);    // Add new customer
        $this->assertEquals(1, $order->quantity);
        $this->assertEquals('5.49', $order->total);
   }

   public function test_updateCardInformation()
   {
        Customer::create([
            'first_name'=>'JackyNew',
            'last_name'=>'ShyuNew',
            'email'=>'shyujackyNew@yahoo.com',
            'password'=>'$2y$04$hP7s3NfMq3Ne7r83MDokIeu0KzX1u8NZIiWRs1RjJDUZgRD2SuUOm',
            'phone'=>'1234567890',
            'address1'=>'100 Centry Road', 
            'address2'=>'Suite 100', 
            'city'=>'Grapevine', 
            'state'=>'TX'
        ]);

        $beforeUpdatedCustomer = DB::table('customers')->where('id', 2)->first();
        $this->assertEquals('', $beforeUpdatedCustomer->zip);
        $this->assertEquals('', $beforeUpdatedCustomer->card_number);
        $this->assertEquals('', $beforeUpdatedCustomer->expired);
        $this->assertEquals('', $beforeUpdatedCustomer->cvv);

        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $response = $this->call('GET', '/order-added', ['productId'=>20, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('POST', '/checkout', [
            'firstname'=>'JackyNew',
            'lastname'=>'ShyuNew',
            'phone'=>'2146808281',
            'email'=>'shyujackyNew@yahoo.com',
            'zip'=>'76034',
            'card'=>'1234567890123456',
            'expired'=>'2212',
            'cvv'=>'123'
        ]);
        //dd($response->json());
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);
        $message = $response->json()['msg'];
        $this->assertEquals('Your order has been submitted succussfully.', $message);
        
        $afterUpdatedCustomer = DB::table('customers')->where('id', 2)->first();
        $this->assertEquals('76034', $afterUpdatedCustomer->zip);
        $this->assertEquals('1234567890123456', $afterUpdatedCustomer->card_number);
        $this->assertEquals('2212', $afterUpdatedCustomer->expired);
        $this->assertEquals('123', $afterUpdatedCustomer->cvv);
   }

   public function test_saveSubItems_single_side()
   {
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $sideItem);
        $response = $this->call('GET', '/order-added', ['productId'=>17, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);


        $response = $this->call('POST', '/checkout', [
            'firstname'=>'Jacky',
            'lastname'=>'Shyu',
            'phone'=>'2146808281',
            'email'=>'shyujacky@yahoo.com',
            'zip'=>'76034',
            'card'=>'1234567890123456',
            'expired'=>'2212',
            'cvv'=>'123'
        ]);
        //dd($response->json());
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);
        $message = $response->json()['msg'];
        $this->assertEquals('Your order has been submitted succussfully.', $message);
        
        $orderSide = DB::table('order_sides')->first();
        $this->assertEquals(1, $orderSide->order_product_id);
        $this->assertEquals(1, $orderSide->side_id);
   }

   public function test_saveSubItems_single_entree()
   {
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $response = $this->call('GET', '/order-added', ['productId'=>20, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('POST', '/checkout', [
            'firstname'=>'Jacky',
            'lastname'=>'Shyu',
            'phone'=>'2146808281',
            'email'=>'shyujacky@yahoo.com',
            'zip'=>'76034',
            'card'=>'1234567890123456',
            'expired'=>'2212',
            'cvv'=>'123'
        ]);
        //dd($response->json());
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);
        $message = $response->json()['msg'];
        $this->assertEquals('Your order has been submitted succussfully.', $message);
        
        $orderEntree = DB::table('order_entrees')->first();
        $this->assertEquals(1, $orderEntree->order_product_id);
        $this->assertEquals(1, $orderEntree->entree_id);
   }

   public function test_saveSubItems_drinks_small_fountain_soft_drink()
   {
        $subItems = array();
        $drinkItem = array('category'=>'DrinkOnly', 'id'=>4, 'quantity'=>1, 'selectBoxId'=>1);
        array_push($subItems, $drinkItem);
        $response = $this->call('GET', '/order-added', ['productId'=>7, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);


        $response = $this->call('POST', '/checkout', [
            'firstname'=>'Jacky',
            'lastname'=>'Shyu',
            'phone'=>'2146808281',
            'email'=>'shyujacky@yahoo.com',
            'zip'=>'76034',
            'card'=>'1234567890123456',
            'expired'=>'2212',
            'cvv'=>'123'
        ]);
        //dd($response->json());
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);
        $message = $response->json()['msg'];
        $this->assertEquals('Your order has been submitted succussfully.', $message);
        
        $orderDrink = DB::table('order_drinks')->first();
        $this->assertEquals(1, $orderDrink->order_product_id);
        $this->assertEquals(4, $orderDrink->drink_id);
        $this->assertEquals(1, $orderDrink->type_id);
   }

   public function test_saveSubItems_combo_kids_meal_with_small_fountain_soft_drink()
   {
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>2, 'quantity'=>1);
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>3, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $drinkItem = array('category'=>'Drink', 'id'=>1, 'quantity'=>1, 'selectBoxId'=>2);
        array_push($subItems, $drinkItem);
        $response = $this->call('GET', '/order-added', ['productId'=>7, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);


        $response = $this->call('POST', '/checkout', [
            'firstname'=>'Jacky',
            'lastname'=>'Shyu',
            'phone'=>'2146808281',
            'email'=>'shyujacky@yahoo.com',
            'zip'=>'76034',
            'card'=>'1234567890123456',
            'expired'=>'2212',
            'cvv'=>'123'
        ]);
        //dd($response->json());
        $status = $response->json()['status'];
        $this->assertEquals(2, $status);
        $message = $response->json()['msg'];
        $this->assertEquals('Your order has been submitted succussfully.', $message);
        
        $orderSubSide = DB::table('order_sub_sides')->first();
        $this->assertEquals(1, $orderSubSide->order_product_id);
        $this->assertEquals(2, $orderSubSide->side_id);

        $orderSubEntree = DB::table('order_sub_entrees')->first();
        $this->assertEquals(1, $orderSubEntree->order_product_id);
        $this->assertEquals(3, $orderSubEntree->entree_id);

        $orderSubDrink = DB::table('order_sub_drinks')->first();
        $this->assertEquals(1, $orderSubDrink->order_product_id);
        $this->assertEquals(1, $orderSubDrink->drink_id);
        $this->assertEquals(2, $orderSubDrink->type_id);
   }
}

class OrderControllerTestForCheckout extends OrderController
{
    protected function saveOrderTable($customerId, $quantity, $total, $note, $created)
    {
        throw new Exception("Test Exception");
    }
}