<?php

namespace Tests\Feature\Http\Controllers\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Single;
use App\Models\Customer;
use App\Models\Order;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Shared\Cart;

class FunctionTest extends TestCase
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

    public function test_retrieveQuantityOfSubItems()
    {
        $controller = new OrderController();

        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $sideItem = array('category'=>'Side', 'id'=>2, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>2);
        array_push($subItems, $entreeItem);
        $entreeItem = array('category'=>'Entree', 'id'=>2, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $drinkItem = array('category'=>'Drink', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $drinkItem);

        $quantityOfSubItems = $controller->retrieveQuantityOfSubItems($subItems);
        $side = $quantityOfSubItems['Side'];
        $entree = $quantityOfSubItems['Entree'];
        $drink = $quantityOfSubItems['Drink'];

        $this->assertEquals(1, $side);
        $this->assertEquals(3, $entree);
        $this->assertEquals(1, $drink);
    }

    public function test_validateSideAndEntreeAndDrink_return_true()
    {
        $controller = new OrderController();

        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $sideItem = array('category'=>'Side', 'id'=>2, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $drinkItem = array('category'=>'Drink', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $drinkItem);

        // Kid's Meal product Id = 16 -- one drink, one side and one entree
        $quantitiesMatched = $controller->validateSideAndEntreeAndDrink(16, $subItems);
        $this->assertEquals(true, $quantitiesMatched);
    }

    public function test_validateSideAndEntreeAndDrink_return_false()
    {
        $controller = new OrderController();

        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $sideItem = array('category'=>'Side', 'id'=>2, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);

        // Part Tray product Id = 15 -- 3 sides and 3 entrees
        $quantitiesMatched = $controller->validateSideAndEntreeAndDrink(15, $subItems);
        $this->assertEquals(false, $quantitiesMatched);
    }

    public function test_loadOrderToSession_Appetizers()
    {
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

        $controller = new OrderControllerTest();
        $controller->loadOrderToSession(1);
        $cart = new Cart(Session::get('cart'));
        
        $orderId = $cart->orderId;
        $this->assertEquals(1, $orderId);

        $menuId = $cart->items;
        $this->assertEquals(1, $cart->items[1]['productItem']->menu_id);    // Appetizer
        //dd($cart);
    }

    public function test_loadOrderToSession_Drinks()
    {
        Order::create([
            'customer_id'=>1,
            'quantity'=>1,
            'total'=>'125',
            'note'=>'Extra cup of ice'
        ]);

        DB::table('order_products')->insert([
            'order_id'=>1,
            'product_id'=>6,
            'quantity'=>1,
            'summary'=>'Canned Soft Drink : Soft drink canned Flaver: Coke $1.25'
        ]);

        DB::table('order_drinks')->insert([
            'order_product_id'=>1,
            'drink_id'=>3,
            'type_id'=>1,
        ]);

        $controller = new OrderControllerTest();
        $controller->loadOrderToSession(1);
        $cart = new Cart(Session::get('cart'));
        
        $orderId = $cart->orderId;
        $this->assertEquals(1, $orderId);

        $menuId = $cart->items;
        $this->assertEquals(2, $cart->items[1]['productItem']->menu_id);    // Drinks
        //dd($cart);
    }

    public function test_loadOrderToSession_Singles_Side()  // retrieveSubItemsForSingle method
    {
        Order::create([
            'customer_id'=>1,
            'quantity'=>1,
            'total'=>'2.49',
            'note'=>'Mild spice'
        ]);

        DB::table('order_products')->insert([
            'order_id'=>1,
            'product_id'=>17,
            'quantity'=>1,
            'summary'=>'Small Side : Small size of side Side: Fried Rice $2.49'
        ]);
        
        DB::table('order_sides')->insert([
            'order_product_id'=>1,
            'side_id'=>1,
        ]);

        $controller = new OrderControllerTest();
        $controller->loadOrderToSession(1);
        $cart = new Cart(Session::get('cart'));
        
        $orderId = $cart->orderId;
        $this->assertEquals(1, $orderId);

        $menuId = $cart->items;
        $this->assertEquals(4, $cart->items[1]['productItem']->menu_id);    // Singles: Sides
        //dd($cart);
    }

    public function test_loadOrderToSession_Singles_Entree()    // Also test retrieveSubItemsForSingle method
    {
        Order::create([
            'customer_id'=>1,
            'quantity'=>1,
            'total'=>'2.49',
            'note'=>'Mild spice'
        ]);

        DB::table('order_products')->insert([
            'order_id'=>1,
            'product_id'=>20,
            'quantity'=>1,
            'summary'=>'Small Chicken : Small size of chicken entree Entree: BBQ Chicken $5.49'
        ]);
        
        DB::table('order_entrees')->insert([
            'order_product_id'=>1,
            'entree_id'=>1,
        ]);

        $controller = new OrderControllerTest();
        $controller->loadOrderToSession(1);
        $cart = new Cart(Session::get('cart'));
        
        $orderId = $cart->orderId;
        $this->assertEquals(1, $orderId);

        $menuId = $cart->items;
        $this->assertEquals(4, $cart->items[1]['productItem']->menu_id);    // Singles: Entrees
        //dd($cart);
    }

    public function test_loadOrderToSession_Combo_Small_Platter()   // Also test retrieveSubItemsForCombos method
    {
        Order::create([
            'customer_id'=>1,
            'quantity'=>1,
            'total'=>'6.40',
            'note'=>'Mild spice'
        ]);

        DB::table('order_products')->insert([
            'order_id'=>1,
            'product_id'=>13,
            'quantity'=>1,
            'summary'=>'Small Platter : Any 1 side & 1 entree Side: Fried Rice(1) Entree: BBQ Chicken(1) $6.40'
        ]);
        
        DB::table('order_sub_sides')->insert([
            'order_product_id'=>1,
            'side_id'=>1,
            'quantity'=>1
        ]);

        DB::table('order_sub_entrees')->insert([
            'order_product_id'=>1,
            'entree_id'=>1,
            'quantity'=>1
        ]);

        $controller = new OrderControllerTest();
        $controller->loadOrderToSession(1);
        $cart = new Cart(Session::get('cart'));
        
        $orderId = $cart->orderId;
        $this->assertEquals(1, $orderId);

        $menuId = $cart->items;
        $this->assertEquals(3, $cart->items[1]['productItem']->menu_id);    // Combo
        //dd($cart);
    }

    public function test_loadOrderToSession_Combo_kids_meal_with_soft_drink()   // Also test retrieveSubItemsForCombos method
    {
        Order::create([
            'customer_id'=>1,
            'quantity'=>1,
            'total'=>'4.99',
            'note'=>'No ice'
        ]);

        DB::table('order_products')->insert([
            'order_id'=>1,
            'product_id'=>16,
            'quantity'=>1,
            'summary'=>'Kids Meal : One small drink, one side and one entree Side: Fried Rice(1) Entree: BBQ Chicken(1) Drink: Small Drink - Coke $4.99'
        ]);
        
        DB::table('order_sub_sides')->insert([
            'order_product_id'=>1,
            'side_id'=>1,
            'quantity'=>1
        ]);

        DB::table('order_sub_entrees')->insert([
            'order_product_id'=>1,
            'entree_id'=>1,
            'quantity'=>1
        ]);

        DB::table('order_sub_drinks')->insert([
            'order_product_id'=>1,
            'drink_id'=>1,
            'type_id'=>1,
            'quantity'=>1
        ]);

        $controller = new OrderControllerTest();
        $controller->loadOrderToSession(1);
        $cart = new Cart(Session::get('cart'));
        
        $orderId = $cart->orderId;
        $this->assertEquals(1, $orderId);

        $menuId = $cart->items;
        $this->assertEquals(3, $cart->items[1]['productItem']->menu_id);    // Combo
        //dd($cart);
    }

    public function test_loadOrderToSession_Combo_kids_meal_with_bottle_water()   // Also test retrieveSubItemsForCombos method
    {
        Order::create([
            'customer_id'=>1,
            'quantity'=>1,
            'total'=>'4.99',
            'note'=>'No ice'
        ]);

        DB::table('order_products')->insert([
            'order_id'=>1,
            'product_id'=>16,
            'quantity'=>1,
            'summary'=>'Kids Meal : One small drink, one side and one entree Side: Fried Rice(1) Entree: BBQ Chicken(1) Drink: Small Drink - Coke $4.99'
        ]);
        
        DB::table('order_sub_sides')->insert([
            'order_product_id'=>1,
            'side_id'=>1,
            'quantity'=>1
        ]);

        DB::table('order_sub_entrees')->insert([
            'order_product_id'=>1,
            'entree_id'=>1,
            'quantity'=>1
        ]);

        DB::table('order_sub_drinks')->insert([
            'order_product_id'=>1,
            'drink_id'=>2,
            'quantity'=>1
        ]);

        $controller = new OrderControllerTest();
        $controller->loadOrderToSession(1);
        $cart = new Cart(Session::get('cart'));
        
        $orderId = $cart->orderId;
        $this->assertEquals(1, $orderId);

        $menuId = $cart->items;
        $this->assertEquals(3, $cart->items[1]['productItem']->menu_id);    // Combo
        //dd($cart);
    }

    public function test_orderUpdated()
    {
        $response = $this->call('GET', '/order-added', ['productId'=>1, 'quantity'=>1, 'subItems'=>'']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/order-updated', ['serialNumber'=>1, 'productId'=>1, 'quantity'=>2, 'subItems'=>'']);
        $response->assertStatus(200);
        $cart = new Cart(Session::get('cart'));
        $this->assertEquals(2, $cart->totalQuantity);
    }

    public function test_orderEditForPopup_appetizers()
    {
        $response = $this->call('GET', '/order-added', ['productId'=>1, 'quantity'=>1, 'subItems'=>'']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/order-edit', ['serialNumber'=>1]);
        $response->assertStatus(200);
        //dd($response->json()['serialNumber']);
        $this->assertEquals(1, $response->json()['serialNumber']);
        $this->assertEquals('Egg Roll (5)', $response->json()['product']['name']);
        $this->assertEquals(1, $response->json()['quantity']);
    }

    public function test_orderEditForPopup_drinks_water()
    {
        $response = $this->call('GET', '/order-added', ['productId'=>4, 'quantity'=>1, 'subItems'=>'']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/order-edit', ['serialNumber'=>1]);
        $response->assertStatus(200);
        //dd($response->json()['serialNumber']);
        $this->assertEquals(1, $response->json()['serialNumber']);
        $this->assertEquals('Water', $response->json()['product']['name']);
        $this->assertEquals(1, $response->json()['quantity']);
    }

    public function test_orderEditForPopup_drinks_canned_soft_drink()
    {
        $subItems = array();
        $drinkItem = array('category'=>'DrinkOnly', 'id'=>3, 'quantity'=>1, 'selectBoxId'=>1);
        array_push($subItems, $drinkItem);
        $response = $this->call('GET', '/order-added', ['productId'=>6, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('GET', '/order-edit', ['serialNumber'=>1]);
        $response->assertStatus(200);
        //dd($response->json());
        $this->assertEquals(1, $response->json()['serialNumber']);
        $this->assertEquals('Canned Soft Drink', $response->json()['product']['name']);
        $this->assertEquals(1, $response->json()['quantity']);
        $this->assertEquals('Canned Drink', $response->json()['drink']['name']);
        $this->assertEquals('Coke', $response->json()['selectDrink']['name']);
        $this->assertEquals(1, count($response->json()['sizeProducts']));
    }

    public function test_orderEditForPopup_drinks_small_fountain_soft_drink()
    {
        $subItems = array();
        $drinkItem = array('category'=>'DrinkOnly', 'id'=>4, 'quantity'=>1, 'selectBoxId'=>1);
        array_push($subItems, $drinkItem);
        $response = $this->call('GET', '/order-added', ['productId'=>7, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('GET', '/order-edit', ['serialNumber'=>1]);
        $response->assertStatus(200);
        //dd($response->json());
        $this->assertEquals(1, $response->json()['serialNumber']);
        $this->assertEquals('Fountain Soft Drink Small', $response->json()['product']['name']);
        $this->assertEquals(1, $response->json()['quantity']);
        $this->assertEquals('Fountain Drink', $response->json()['drink']['name']);
        $this->assertEquals('Coke', $response->json()['selectDrink']['name']);
        $this->assertEquals(3, count($response->json()['sizeProducts']));
    }

    public function test_orderEditForPopup_singles_side()
    {
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $sideItem);
        $response = $this->call('GET', '/order-added', ['productId'=>17, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('GET', '/order-edit', ['serialNumber'=>1]);
        $response->assertStatus(200);
        //dd($response->json());
        $this->assertEquals(1, $response->json()['serialNumber']);
        $this->assertEquals('Small Side', $response->json()['product']['name']);
        $this->assertEquals(1, $response->json()['quantity']);
        //dd($response->json()['productSidesOrEntrees']);
        $this->assertEquals(3, count($response->json()['productSidesOrEntrees']));
        $this->assertEquals('Fried Rice', $response->json()['sideOrEntree']['name']);
    }

    public function test_orderEditForPopup_singles_entree_chicken()
    {
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $response = $this->call('GET', '/order-added', ['productId'=>20, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('GET', '/order-edit', ['serialNumber'=>1]);
        $response->assertStatus(200);
        //dd($response->json());
        $this->assertEquals(1, $response->json()['serialNumber']);
        $this->assertEquals('Small Chicken', $response->json()['product']['name']);
        $this->assertEquals(1, $response->json()['quantity']);
        //dd($response->json()['productSidesOrEntrees']);
        $this->assertEquals(3, count($response->json()['productSidesOrEntrees']));
        $this->assertEquals('BBQ Chicken', $response->json()['sideOrEntree']['name']);
    }

    public function test_orderEditForPopup_singles_entree_beef()
    {
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>10, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $response = $this->call('GET', '/order-added', ['productId'=>23, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('GET', '/order-edit', ['serialNumber'=>1]);
        $response->assertStatus(200);
        //dd($response->json());
        $this->assertEquals(1, $response->json()['serialNumber']);
        $this->assertEquals('Small Beef', $response->json()['product']['name']);
        $this->assertEquals(1, $response->json()['quantity']);
        //dd($response->json()['productSidesOrEntrees']);
        $this->assertEquals(3, count($response->json()['productSidesOrEntrees']));
        $this->assertEquals('Beef Broccoli', $response->json()['sideOrEntree']['name']);
    }

    public function test_orderEditForPopup_singles_entree_shrimp()
    {
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>13, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $response = $this->call('GET', '/order-added', ['productId'=>26, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('GET', '/order-edit', ['serialNumber'=>1]);
        $response->assertStatus(200);
        //dd($response->json());
        $this->assertEquals(1, $response->json()['serialNumber']);
        $this->assertEquals('Small Shrimp', $response->json()['product']['name']);
        $this->assertEquals(1, $response->json()['quantity']);
        //dd($response->json()['productSidesOrEntrees']);
        $this->assertEquals(3, count($response->json()['productSidesOrEntrees']));
        $this->assertEquals('Broccoli Shrimp', $response->json()['sideOrEntree']['name']);
    }

    public function test_orderEditForPopup_combo_party_tray()
    {
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $sideItem);
        $sideItem = array('category'=>'Side', 'id'=>2, 'quantity'=>2);
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $entreeItem = array('category'=>'Entree', 'id'=>10, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $entreeItem = array('category'=>'Entree', 'id'=>13, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $response = $this->call('GET', '/order-added', ['productId'=>15, 'quantity'=>1, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('GET', '/order-edit', ['serialNumber'=>1]);
        $response->assertStatus(200);
        //dd($response->json());
        $this->assertEquals(1, $response->json()['serialNumber']);
        $this->assertEquals('Party Tray', $response->json()['product']['name']);
        $this->assertEquals(1, $response->json()['quantity']);
        $this->assertEquals(3, count($response->json()['sides']));
        $this->assertEquals(9, count($response->json()['chickenEntrees']));
        $this->assertEquals(3, count($response->json()['beefEntrees']));
        $this->assertEquals(2, count($response->json()['shrimpEntrees']));
        $this->assertEquals(3, $response->json()['combo']['side']);
        $this->assertEquals(3, $response->json()['combo']['entree']);
        $this->assertEquals(2, count($response->json()['comboDrinks']));
        $this->assertEquals(8, count($response->json()['fountains']));
        $this->assertEquals(5, count($response->json()['subItems']));
        $this->assertEquals('Fried Rice', $response->json()['subItems'][0]['item']['name']);
        $this->assertEquals('Chow Mein', $response->json()['subItems'][1]['item']['name']);
        $this->assertEquals('BBQ Chicken', $response->json()['subItems'][2]['item']['name']);
        $this->assertEquals('Beef Broccoli', $response->json()['subItems'][3]['item']['name']);
        $this->assertEquals('Broccoli Shrimp', $response->json()['subItems'][4]['item']['name']);
    }
    
    public function test_orderEditForPopup_cart_is_empty()
    {
        $response = $this->call('GET', '/order-edit', ['serialNumber'=>1]);
        $response->assertStatus(200);
        //dd($response->json());
    }

    public function test_get_cart_note_with_existing_note()
    {
        // Route::get('/cart-note', [OrderController::class, 'cartNote']);
        $response = $this->call('GET', '/cart-note', ['note'=>'Mild spicy']);
        $response->assertStatus(200);
        $note = $response->json()['note'];
        $this->assertEquals('Mild spicy', $note);

        $response = $this->call('GET', '/cart-note', ['note'=>'Mild spicy updated']);
        $response->assertStatus(200);
        $note = $response->json()['note'];
        $this->assertEquals('Mild spicy updated', $note);
    }

    public function test_cartQuantityUpdated_with_appetizer()
    {
        $response = $this->call('GET', '/order-added', ['productId'=>1, 'quantity'=>1, 'subItems'=>'']);
        $response->assertStatus(200);

        $response = $this->call('GET', '/cart-quantity', ['serialNumber'=>1, 'quantity'=>2]);
        //dd($response->json()['priceDetail']);
        //dd($response->json()['items']);
        $this->assertEquals(2, $response->json()['priceDetail']['totalQuantity']);
        $this->assertEquals(2, $response->json()['items'][1]['quantity']);
    }
}

class OrderControllerTest extends OrderController
{
    public function loadOrderToSession($orderId)
    {
        return parent::loadOrderToSession($orderId);
    }
}

