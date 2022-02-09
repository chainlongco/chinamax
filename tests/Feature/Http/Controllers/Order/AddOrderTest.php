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
use App\Http\Controllers\OrderController;

class AddOrderTest extends TestCase
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
    }

    public function test_add_appetizer_with_existing_order_for_testing_session_has_cart()
    {
        $productId = 1;
        $quantity = 2;
        $subItems = array();

        $expect = '~<span id="cart_count" class="text-warning bg-light">2</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $productId = 2;
        $quantity = 1;
        $subItems = array();

        $expect = '~<span id="cart_count" class="text-warning bg-light">3</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);
    }

    public function test_add_appetizer()
    {
        $productId = 1;
        $quantity = 1;
        $subItems = array();

        $expect = '~<span id="cart_count" class="text-warning bg-light">1</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);
        
        // Cart Class: $$serialNumber, $items, $totalQuantity, $totalPrice, $note, $created, $orderId
        $serialNumber = Session::get('cart')->serialNumber;
        $this->assertEquals(1, $serialNumber);
        $items = Session::get('cart')->items;
        $this->assertEquals(1, count($items));
        $totalQuantity = Session::get('cart')->totalQuantity;
        $this->assertEquals(1, $totalQuantity);
        $totalPrice = Session::get('cart')->totalPrice;
        $this->assertEquals(4.59, $totalPrice);
        $note = Session::get('cart')->note;
        $this->assertEquals('', $note);
        $created = Session::get('cart')->created;
        $this->assertEquals(null, $created);
        $orderId = Session::get('cart')->orderId;
        $this->assertEquals(null, $orderId);

        // items: Appetizers, combos, drinks, single sides/entrees
        // each item is different after merging same appetizer, combo, drink or single side/entree
        $item = Session::get('cart')->items[1]; // The number: 1 is from $serialNumber, each $item includes: productItem, subItems, quantity, and totalPricePerProductItem. See: addNewItem method in Cart.php
        $productItem = $item['productItem'];
        $this->assertEquals(1, $productItem->id);
        $this->assertEquals(0, count($item['subItems']));
        $this->assertEquals(1, $item['quantity']);
        $this->assertEquals(4.59, $item['totalPricePerProductItem']);   // Calculate unit price if there is extra charge like Kid's meal with bottle water which has extra charge $0.75

        // subItems: null information
        //$subItem = $item['subItems'][0];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        //$this->assertEquals('', $subItem['category']);
        //$this->assertEquals(0, $subItem['quantity']);
        //$this->assertEquals(1, $subItem['item']->id);   // Side: id, name, description, gallery
        //$this->assertEquals('', $subItem['item']->name);
        //$this->assertEquals('', $subItem['item']->description);
        //$this->assertEquals('', $subItem['item']->gallery);
        //$this->assertEquals(1, $subItem['selectDrink']);  // Only apply to Drink -- canned drink, fountain drink, fresh juice. See: processSubItems method in Cart.php

        // product information
        $this->assertEquals(1, $item['productItem']->id);
        $this->assertEquals('Egg Roll (5)', $item['productItem']->name);
        $this->assertEquals(4.59, $item['productItem']->price);
        $this->assertEquals('5 egg rolls', $item['productItem']->description);
        $this->assertEquals('EggRoll.jpg', $item['productItem']->gallery);
        $this->assertEquals('', $item['productItem']->category);



        $item = Session::get('cart')->items[1];
        $this->assertEquals(1, $item['quantity']);
        $this->assertEquals(0, count($item['subItems']));
        $this->assertEquals(4.59, $item['totalPricePerProductItem']);
        // product information
        $this->assertEquals(1, $item['productItem']->id);
        $this->assertEquals('Egg Roll (5)', $item['productItem']->name);
        $this->assertEquals(4.59, $item['productItem']->price);
        $this->assertEquals('5 egg rolls', $item['productItem']->description);
        $this->assertEquals('EggRoll.jpg', $item['productItem']->gallery);
        //dd($cart->items[1]['quantity']);
        //dd($cart);
    }

    public function test_add_single_side()
    {
        $productId = 17;
        $quantity = 2;
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>2);
        array_push($subItems, $sideItem);

        $expect = '~<span id="cart_count" class="text-warning bg-light">2</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        // Cart Class: $serialNumber, $items, $totalQuantity, $totalPrice, $note, $created, $orderId
        $serialNumber = Session::get('cart')->serialNumber;
        $this->assertEquals(1, $serialNumber);
        $items = Session::get('cart')->items;
        $this->assertEquals(1, count($items));
        $totalQuantity = Session::get('cart')->totalQuantity;
        $this->assertEquals(2, $totalQuantity);
        $totalPrice = Session::get('cart')->totalPrice;
        $this->assertEquals(4.98, $totalPrice);
        $note = Session::get('cart')->note;
        $this->assertEquals('', $note);
        $created = Session::get('cart')->created;
        $this->assertEquals(null, $created);
        $orderId = Session::get('cart')->orderId;
        $this->assertEquals(null, $orderId);
        
        // items: Appetizers, combos, drinks, single sides/entrees
        // each item is different after merging same appetizer, combo, drink or single side/entree
        $item = Session::get('cart')->items[1]; // The number: 1 is from $serialNumber, each $item includes: productItem, subItems, quantity, and totalPricePerProductItem. See: addNewItem method in Cart.php
        $productItem = $item['productItem'];
        $this->assertEquals(17, $productItem->id);
        $this->assertEquals(1, count($item['subItems']));
        $this->assertEquals(2, $item['quantity']);
        $this->assertEquals(2.49, $item['totalPricePerProductItem']);   // Calculate unit price if there is extra charge like Kid's meal with bottle water which has extra charge $0.75

        // subItems:Side information
        $subItem = $item['subItems'][0];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Side', $subItem['category']);
        $this->assertEquals(2, $subItem['quantity']);
        $this->assertEquals(1, $subItem['item']->id);   // Side: id, name, description, gallery
        $this->assertEquals('Fried Rice', $subItem['item']->name);
        $this->assertEquals('Fried rice with some vegetable and soy source', $subItem['item']->description);
        $this->assertEquals('FriedRice.jpg', $subItem['item']->gallery);
        //$this->assertEquals(null, $subItem['selectDrink']);   // Only apply to Drink -- canned drink, fountain drink, fresh juice. See: processSubItems method in Cart.php

        // product information
        $this->assertEquals(17, $item['productItem']->id);  // Product: id, name, price, description, gallery, category
        $this->assertEquals('Small Side', $item['productItem']->name);
        $this->assertEquals(2.49, $item['productItem']->price);
        $this->assertEquals('Small size of side', $item['productItem']->description);
        $this->assertEquals('', $item['productItem']->gallery);
        $this->assertEquals('Side', $item['productItem']->category);
    }

    public function test_add_single_chicken()
    {
        $productId = 20;
        $quantity = 3;
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>3);
        array_push($subItems, $entreeItem);

        $expect = '~<span id="cart_count" class="text-warning bg-light">3</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        // Cart Class: $serialNumber, $items, $totalQuantity, $totalPrice, $note, $created, $orderId
        $serialNumber = Session::get('cart')->serialNumber;
        $this->assertEquals(1, $serialNumber);
        $items = Session::get('cart')->items;
        $this->assertEquals(1, count($items));
        $totalQuantity = Session::get('cart')->totalQuantity;
        $this->assertEquals(3, $totalQuantity);
        $totalPrice = Session::get('cart')->totalPrice;
        $this->assertEquals(16.47, $totalPrice);
        $note = Session::get('cart')->note;
        $this->assertEquals('', $note);
        $created = Session::get('cart')->created;
        $this->assertEquals(null, $created);
        $orderId = Session::get('cart')->orderId;
        $this->assertEquals(null, $orderId);

        // items: Appetizers, combos, drinks, single sides/entrees
        // each item is different after merging same appetizer, combo, drink or single side/entree
        $item = Session::get('cart')->items[1]; // The number: 1 is from $serialNumber, each $item includes: productItem, subItems, quantity, and totalPricePerProductItem. See: addNewItem method in Cart.php
        $productItem = $item['productItem'];
        $this->assertEquals(20, $productItem->id);
        $this->assertEquals(1, count($item['subItems']));
        $this->assertEquals(3, $item['quantity']);
        $this->assertEquals(5.49, $item['totalPricePerProductItem']);   // Calculate unit price if there is extra charge like Kid's meal with bottle water which has extra charge $0.75

        // subItems:Entree information
        $subItem = $item['subItems'][0];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Entree', $subItem['category']);
        $this->assertEquals(3, $subItem['quantity']);
        $this->assertEquals(1, $subItem['item']->id);   // Entree: id, name, description, gallery
        $this->assertEquals('BBQ Chicken', $subItem['item']->name);
        $this->assertEquals('BBQ chicken entree', $subItem['item']->description);
        $this->assertEquals('BBQChicken.jpg', $subItem['item']->gallery);
        //$this->assertEquals(null, $subItem['selectDrink']);   // Only apply to Drink -- canned drink, fountain drink, fresh juice. See: processSubItems method in Cart.php

        // product information
        $this->assertEquals(20, $item['productItem']->id);  // Product: id, name, price, description, gallery, category
        $this->assertEquals('Small Chicken', $item['productItem']->name);
        $this->assertEquals(5.49, $item['productItem']->price);
        $this->assertEquals('Small size of chicken entree', $item['productItem']->description);
        $this->assertEquals('', $item['productItem']->gallery);
        $this->assertEquals('Chicken', $item['productItem']->category);
    }

    public function test_add_single_Beef()
    {
        $productId = 23;
        $quantity = 4;
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>10, 'quantity'=>4);
        array_push($subItems, $entreeItem);

        $expect = '~<span id="cart_count" class="text-warning bg-light">4</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        // Cart Class: $serialNumber, $items, $totalQuantity, $totalPrice, $note, $created, $orderId
        $serialNumber = Session::get('cart')->serialNumber;
        $this->assertEquals(1, $serialNumber);
        $items = Session::get('cart')->items;
        $this->assertEquals(1, count($items));
        $totalQuantity = Session::get('cart')->totalQuantity;
        $this->assertEquals(4, $totalQuantity);
        $totalPrice = Session::get('cart')->totalPrice;
        $this->assertEquals(23.96, $totalPrice);
        $note = Session::get('cart')->note;
        $this->assertEquals('', $note);
        $created = Session::get('cart')->created;
        $this->assertEquals(null, $created);
        $orderId = Session::get('cart')->orderId;
        $this->assertEquals(null, $orderId);

        // items: Appetizers, combos, drinks, single sides/entrees
        // each item is different after merging same appetizer, combo, drink or single side/entree
        $item = Session::get('cart')->items[1]; // The number: 1 is from $serialNumber, each $item includes: productItem, subItems, quantity, and totalPricePerProductItem. See: addNewItem method in Cart.php
        $productItem = $item['productItem'];
        $this->assertEquals(23, $productItem->id);
        $this->assertEquals(1, count($item['subItems']));
        $this->assertEquals(4, $item['quantity']);
        $this->assertEquals(5.99, $item['totalPricePerProductItem']);   // Calculate unit price if there is extra charge like Kid's meal with bottle water which has extra charge $0.75

        // subItems:Entree information
        $subItem = $item['subItems'][0];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Entree', $subItem['category']);
        $this->assertEquals(4, $subItem['quantity']);
        $this->assertEquals(10, $subItem['item']->id);   // Entree: id, name, description, gallery
        $this->assertEquals('Beef Broccoli', $subItem['item']->name);
        $this->assertEquals('Beef broccoli entree', $subItem['item']->description);
        $this->assertEquals('BeefBroccoli.jpg', $subItem['item']->gallery);
        //$this->assertEquals(null, $subItem['selectDrink']);   // Only apply to Drink -- canned drink, fountain drink, fresh juice. See: processSubItems method in Cart.php

        // product information
        $this->assertEquals(23, $item['productItem']->id);  // Product: id, name, price, description, gallery, category
        $this->assertEquals('Small Beef', $item['productItem']->name);
        $this->assertEquals(5.99, $item['productItem']->price);
        $this->assertEquals('Small size of beef entree', $item['productItem']->description);
        $this->assertEquals('', $item['productItem']->gallery);
        $this->assertEquals('Beef', $item['productItem']->category);
    }

    public function test_add_single_Shrimp()
    {
        $productId = 26;
        $quantity = 5;
        $subItems = array();
        $entreeItem = array('category'=>'Entree', 'id'=>13, 'quantity'=>5);
        array_push($subItems, $entreeItem);

        $expect = '~<span id="cart_count" class="text-warning bg-light">5</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        // Cart Class: $serialNumber, $items, $totalQuantity, $totalPrice, $note, $created, $orderId
        $serialNumber = Session::get('cart')->serialNumber;
        $this->assertEquals(1, $serialNumber);
        $items = Session::get('cart')->items;
        $this->assertEquals(1, count($items));
        $totalQuantity = Session::get('cart')->totalQuantity;
        $this->assertEquals(5, $totalQuantity);
        $totalPrice = Session::get('cart')->totalPrice;
        $this->assertEquals(32.45, $totalPrice);
        $note = Session::get('cart')->note;
        $this->assertEquals('', $note);
        $created = Session::get('cart')->created;
        $this->assertEquals(null, $created);
        $orderId = Session::get('cart')->orderId;
        $this->assertEquals(null, $orderId);

        // items: Appetizers, combos, drinks, single sides/entrees
        // each item is different after merging same appetizer, combo, drink or single side/entree
        $item = Session::get('cart')->items[1]; // The number: 1 is from $serialNumber, each $item includes: productItem, subItems, quantity, and totalPricePerProductItem. See: addNewItem method in Cart.php
        $productItem = $item['productItem'];
        $this->assertEquals(26, $productItem->id);
        $this->assertEquals(1, count($item['subItems']));
        $this->assertEquals(5, $item['quantity']);
        $this->assertEquals(6.49, $item['totalPricePerProductItem']);   // Calculate unit price if there is extra charge like Kid's meal with bottle water which has extra charge $0.75

        // subItems:Entree information
        $subItem = $item['subItems'][0];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Entree', $subItem['category']);
        $this->assertEquals(5, $subItem['quantity']);
        $this->assertEquals(13, $subItem['item']->id);   // Entree: id, name, description, gallery
        $this->assertEquals('Broccoli Shrimp', $subItem['item']->name);
        $this->assertEquals('Broccoli shrimp entree', $subItem['item']->description);
        $this->assertEquals('BroccoliShrimp.jpg', $subItem['item']->gallery);
        //$this->assertEquals(null, $subItem['selectDrink']);   // Only apply to Drink -- canned drink, fountain drink, fresh juice. See: processSubItems method in Cart.php

        // product information
        $this->assertEquals(26, $item['productItem']->id);  // Product: id, name, price, description, gallery, category
        $this->assertEquals('Small Shrimp', $item['productItem']->name);
        $this->assertEquals(6.49, $item['productItem']->price);
        $this->assertEquals('Small size of shrimp entree', $item['productItem']->description);
        $this->assertEquals('', $item['productItem']->gallery);
        $this->assertEquals('Shrimp', $item['productItem']->category);
    }

    public function test_add_drink_only_bottle_water()
    {
        $productId = 5;
        $quantity = 1;
        $subItems = array();

        $expect = '~<span id="cart_count" class="text-warning bg-light">1</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        // Cart Class: $serialNumber, $items, $totalQuantity, $totalPrice, $note, $created, $orderId
        $serialNumber = Session::get('cart')->serialNumber;
        $this->assertEquals(1, $serialNumber);
        $items = Session::get('cart')->items;
        $this->assertEquals(1, count($items));
        $totalQuantity = Session::get('cart')->totalQuantity;
        $this->assertEquals(1, $totalQuantity);
        $totalPrice = Session::get('cart')->totalPrice;
        $this->assertEquals(1.50, $totalPrice);
        $note = Session::get('cart')->note;
        $this->assertEquals('', $note);
        $created = Session::get('cart')->created;
        $this->assertEquals(null, $created);
        $orderId = Session::get('cart')->orderId;
        $this->assertEquals(null, $orderId);

        // items: Appetizers, combos, drinks, single sides/entrees
        // each item is different after merging same appetizer, combo, drink or single side/entree
        $item = Session::get('cart')->items[1]; // The number: 1 is from $serialNumber, each $item includes: productItem, subItems, quantity, and totalPricePerProductItem. See: addNewItem method in Cart.php
        $productItem = $item['productItem'];
        $this->assertEquals(5, $productItem->id);
        $this->assertEquals(0, count($item['subItems']));
        $this->assertEquals(1, $item['quantity']);
        $this->assertEquals(1.50, $item['totalPricePerProductItem']);   // Calculate unit price if there is extra charge like Kid's meal with bottle water which has extra charge $0.75

        // subItems: null information
        //$subItem = $item['subItems'][0];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        //$this->assertEquals('', $subItem['category']);
        //$this->assertEquals(0, $subItem['quantity']);
        //$this->assertEquals(1, $subItem['item']->id);   // Entree: id, name, description, gallery
        //$this->assertEquals('', $subItem['item']->name);
        //$this->assertEquals('', $subItem['item']->description);
        //$this->assertEquals('', $subItem['item']->gallery);
        //$this->assertEquals(null, $subItem['selectDrink']);   // Only apply to Drink -- canned drink, fountain drink, fresh juice. See: processSubItems method in Cart.php

        // product information
        $this->assertEquals(5, $item['productItem']->id);  // Product: id, name, price, description, gallery, category
        $this->assertEquals('Bottle Water', $item['productItem']->name);
        $this->assertEquals(1.50, $item['productItem']->price);
        $this->assertEquals('Bottle water', $item['productItem']->description);
        $this->assertEquals('', $item['productItem']->gallery);
        $this->assertEquals('Bottle Water', $item['productItem']->category);
    }

    public function test_add_drink_only_canned_drink()
    {
        $productId = 6;
        $quantity = 1;
        $subItems = array();
        $drinkItem = array('category'=>'DrinkOnly', 'id'=>3, 'quantity'=>1, 'selectBoxId'=>1);
        array_push($subItems, $drinkItem);

        $expect = '~<span id="cart_count" class="text-warning bg-light">1</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        // Cart Class: $serialNumber, $items, $totalQuantity, $totalPrice, $note, $created, $orderId
        $serialNumber = Session::get('cart')->serialNumber;
        $this->assertEquals(1, $serialNumber);
        $items = Session::get('cart')->items;
        $this->assertEquals(1, count($items));
        $totalQuantity = Session::get('cart')->totalQuantity;
        $this->assertEquals(1, $totalQuantity);
        $totalPrice = Session::get('cart')->totalPrice;
        $this->assertEquals(1.25, $totalPrice);
        $note = Session::get('cart')->note;
        $this->assertEquals('', $note);
        $created = Session::get('cart')->created;
        $this->assertEquals(null, $created);
        $orderId = Session::get('cart')->orderId;
        $this->assertEquals(null, $orderId);

        // items: Appetizers, combos, drinks, single sides/entrees
        // each item is different after merging same appetizer, combo, drink or single side/entree
        $item = Session::get('cart')->items[1]; // The number: 1 is from $serialNumber, each $item includes: productItem, subItems, quantity, and totalPricePerProductItem. See: addNewItem method in Cart.php
        $productItem = $item['productItem'];
        $this->assertEquals(6, $productItem->id);
        $this->assertEquals(1, count($item['subItems']));
        $this->assertEquals(1, $item['quantity']);
        $this->assertEquals(1.25, $item['totalPricePerProductItem']);   // Calculate unit price if there is extra charge like Kid's meal with bottle water which has extra charge $0.75

        // subItems: Drink - Canned information
        $subItem = $item['subItems'][0];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('DrinkOnly', $subItem['category']);
        $this->assertEquals(1, $subItem['quantity']);
        $this->assertEquals(3, $subItem['item']->id);   // Drinks: id, name, description, gallery
        $this->assertEquals('Canned Drink', $subItem['item']->name);
        $this->assertEquals('A canned soft drink', $subItem['item']->description);
        $this->assertEquals('SoftDrinkCan.jpg', $subItem['item']->gallery);
        $this->assertEquals(1, $subItem['selectDrink']->id);   // Only apply to Drink -- canned drink, fountain drink, fresh juice. See: processSubItems method in Cart.php
        $this->assertEquals('Coke', $subItem['selectDrink']->name);

        // product information
        $this->assertEquals(6, $item['productItem']->id);  // Product: id, name, price, description, gallery, category
        $this->assertEquals('Canned Soft Drink', $item['productItem']->name);
        $this->assertEquals(1.25, $item['productItem']->price);
        $this->assertEquals('Soft drink canned', $item['productItem']->description);
        $this->assertEquals('', $item['productItem']->gallery);
        $this->assertEquals('Canned Drink', $item['productItem']->category);
    }

    public function test_add_drink_only_fountain_drink()
    {
        $productId = 7;
        $quantity = 2;
        $subItems = array();
        $drinkItem = array('category'=>'DrinkOnly', 'id'=>4, 'quantity'=>2, 'selectBoxId'=>8);
        array_push($subItems, $drinkItem);

        $expect = '~<span id="cart_count" class="text-warning bg-light">2</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        // Cart Class: $serialNumber, $items, $totalQuantity, $totalPrice, $note, $created, $orderId
        $serialNumber = Session::get('cart')->serialNumber;
        $this->assertEquals(1, $serialNumber);
        $items = Session::get('cart')->items;
        $this->assertEquals(1, count($items));
        $totalQuantity = Session::get('cart')->totalQuantity;
        $this->assertEquals(2, $totalQuantity);
        $totalPrice = Session::get('cart')->totalPrice;
        $this->assertEquals(3.18, $totalPrice);
        $note = Session::get('cart')->note;
        $this->assertEquals('', $note);
        $created = Session::get('cart')->created;
        $this->assertEquals(null, $created);
        $orderId = Session::get('cart')->orderId;
        $this->assertEquals(null, $orderId);

        // items: Appetizers, combos, drinks, single sides/entrees
        // each item is different after merging same appetizer, combo, drink or single side/entree
        $item = Session::get('cart')->items[1]; // The number: 1 is from $serialNumber, each $item includes: productItem, subItems, quantity, and totalPricePerProductItem. See: addNewItem method in Cart.php
        $productItem = $item['productItem'];
        $this->assertEquals(7, $productItem->id);
        $this->assertEquals(1, count($item['subItems']));
        $this->assertEquals(2, $item['quantity']);
        $this->assertEquals(1.59, $item['totalPricePerProductItem']);   // Calculate unit price if there is extra charge like Kid's meal with bottle water which has extra charge $0.75

        // subItems: Drink - Fountain information
        $subItem = $item['subItems'][0];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('DrinkOnly', $subItem['category']);
        $this->assertEquals(2, $subItem['quantity']);
        $this->assertEquals(4, $subItem['item']->id);   // Drinks: id, name, description, gallery
        $this->assertEquals('Fountain Drink', $subItem['item']->name);
        $this->assertEquals('Different size of fountain soft drink', $subItem['item']->description);
        $this->assertEquals('SoftDrinkFountain.jpg', $subItem['item']->gallery);
        $this->assertEquals(8, $subItem['selectDrink']->id);   // Only apply to Drink -- canned drink, fountain drink, fresh juice. See: processSubItems method in Cart.php
        $this->assertEquals('Fanta', $subItem['selectDrink']->name);

        // product information
        $this->assertEquals(7, $item['productItem']->id);  // Product: id, name, price, description, gallery, category
        $this->assertEquals('Fountain Soft Drink Small', $item['productItem']->name);
        $this->assertEquals(1.59, $item['productItem']->price);
        $this->assertEquals('Small size fountain soft drink', $item['productItem']->description);
        $this->assertEquals('', $item['productItem']->gallery);
        $this->assertEquals('Fountain Drink', $item['productItem']->category);
    }

    public function test_add_regular_platter()
    {
        $productId = 13;
        $quantity = 2;
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>2);
        array_push($subItems, $entreeItem);

        $expect = '~<span id="cart_count" class="text-warning bg-light">2</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        // Cart Class: $serialNumber, $items, $totalQuantity, $totalPrice, $note, $created, $orderId
        $serialNumber = Session::get('cart')->serialNumber;
        $this->assertEquals(1, $serialNumber);
        $items = Session::get('cart')->items;
        $this->assertEquals(1, count($items));
        $totalQuantity = Session::get('cart')->totalQuantity;
        $this->assertEquals(2, $totalQuantity);
        $totalPrice = Session::get('cart')->totalPrice;
        $this->assertEquals(15.16, $totalPrice);
        $note = Session::get('cart')->note;
        $this->assertEquals('', $note);
        $created = Session::get('cart')->created;
        $this->assertEquals(null, $created);
        $orderId = Session::get('cart')->orderId;
        $this->assertEquals(null, $orderId);

        // items: Appetizers, combos, drinks, single sides/entrees
        // each item is different after merging same appetizer, combo, drink or single side/entree
        $item = Session::get('cart')->items[1]; // The number: 1 is from $serialNumber, each $item includes: productItem, subItems, quantity, and totalPricePerProductItem. See: addNewItem method in Cart.php
        $productItem = $item['productItem'];
        $this->assertEquals(13, $productItem->id);
        $this->assertEquals(2, count($item['subItems']));
        $this->assertEquals(2, $item['quantity']);
        $this->assertEquals(7.58, $item['totalPricePerProductItem']);   // Calculate unit price if there is extra charge like Kid's meal with bottle water which has extra charge $0.75

        // subItems: Side information
        $subItem = $item['subItems'][0];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Side', $subItem['category']);
        $this->assertEquals(1, $subItem['quantity']);
        $this->assertEquals(1, $subItem['item']->id);   // Side: id, name, description, gallery
        $this->assertEquals('Fried Rice', $subItem['item']->name);
        $this->assertEquals('Fried rice with some vegetable and soy source', $subItem['item']->description);
        $this->assertEquals('FriedRice.jpg', $subItem['item']->gallery);
        // subItems: Entree information
        $subItem = $item['subItems'][1];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Entree', $subItem['category']);
        $this->assertEquals(2, $subItem['quantity']);
        $this->assertEquals(1, $subItem['item']->id);   // Entree: id, name, description, gallery
        $this->assertEquals('BBQ Chicken', $subItem['item']->name);
        $this->assertEquals('BBQ chicken entree', $subItem['item']->description);
        $this->assertEquals('BBQChicken.jpg', $subItem['item']->gallery);

        // product information
        $this->assertEquals(13, $item['productItem']->id);  // Product: id, name, price, description, gallery, category
        $this->assertEquals('Regular Platter', $item['productItem']->name);
        $this->assertEquals(7.58, $item['productItem']->price);
        $this->assertEquals('Any 1 side & 2 entrees', $item['productItem']->description);
        $this->assertEquals('RegularPlatter.jpg', $item['productItem']->gallery);
        $this->assertEquals('', $item['productItem']->category);
    }

    public function test_add_part_tray()
    {
        $productId = 15;
        $quantity = 2;
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $sideItem);
        $sideItem = array('category'=>'Side', 'id'=>2, 'quantity'=>2);
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>2);
        array_push($subItems, $entreeItem);
        $entreeItem = array('category'=>'Entree', 'id'=>2, 'quantity'=>1);
        array_push($subItems, $entreeItem);

        $expect = '~<span id="cart_count" class="text-warning bg-light">2</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        // Cart Class: $serialNumber, $items, $totalQuantity, $totalPrice, $note, $created, $orderId
        $serialNumber = Session::get('cart')->serialNumber;
        $this->assertEquals(1, $serialNumber);
        $items = Session::get('cart')->items;
        $this->assertEquals(1, count($items));
        $totalQuantity = Session::get('cart')->totalQuantity;
        $this->assertEquals(2, $totalQuantity);
        $totalPrice = Session::get('cart')->totalPrice;
        $this->assertEquals(47.98, $totalPrice);
        $note = Session::get('cart')->note;
        $this->assertEquals('', $note);
        $created = Session::get('cart')->created;
        $this->assertEquals(null, $created);
        $orderId = Session::get('cart')->orderId;
        $this->assertEquals(null, $orderId);

        // items: Appetizers, combos, drinks, single sides/entrees
        // each item is different after merging same appetizer, combo, drink or single side/entree
        $item = Session::get('cart')->items[1]; // The number: 1 is from $serialNumber, each $item includes: productItem, subItems, quantity, and totalPricePerProductItem. See: addNewItem method in Cart.php
        $productItem = $item['productItem'];
        $this->assertEquals(15, $productItem->id);
        $this->assertEquals(4, count($item['subItems']));
        $this->assertEquals(2, $item['quantity']);
        $this->assertEquals(23.99, $item['totalPricePerProductItem']);   // Calculate unit price if there is extra charge like Kid's meal with bottle water which has extra charge $0.75

        // subItems: Side 1 information
        $subItem = $item['subItems'][0];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Side', $subItem['category']);
        $this->assertEquals(1, $subItem['quantity']);
        $this->assertEquals(1, $subItem['item']->id);   // Side: id, name, description, gallery
        $this->assertEquals('Fried Rice', $subItem['item']->name);
        $this->assertEquals('Fried rice with some vegetable and soy source', $subItem['item']->description);
        $this->assertEquals('FriedRice.jpg', $subItem['item']->gallery);
        // subItems: Side 2 information
        $subItem = $item['subItems'][1];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Side', $subItem['category']);
        $this->assertEquals(2, $subItem['quantity']);
        $this->assertEquals(2, $subItem['item']->id);   // Side: id, name, description, gallery
        $this->assertEquals('Chow Mein', $subItem['item']->name);
        $this->assertEquals('Chow mein with some vegetable', $subItem['item']->description);
        $this->assertEquals('ChowMein.jpg', $subItem['item']->gallery);
        // subItems: Entree 1 information
        $subItem = $item['subItems'][2];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Entree', $subItem['category']);
        $this->assertEquals(2, $subItem['quantity']);
        $this->assertEquals(1, $subItem['item']->id);   // Entree: id, name, description, gallery
        $this->assertEquals('BBQ Chicken', $subItem['item']->name);
        $this->assertEquals('BBQ chicken entree', $subItem['item']->description);
        $this->assertEquals('BBQChicken.jpg', $subItem['item']->gallery);
        // subItems: Entree 1 information
        $subItem = $item['subItems'][3];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Entree', $subItem['category']);
        $this->assertEquals(1, $subItem['quantity']);
        $this->assertEquals(2, $subItem['item']->id);   // Entree: id, name, description, gallery
        $this->assertEquals('Black Pepper Chicken', $subItem['item']->name);
        $this->assertEquals('Black pepper chicken entree', $subItem['item']->description);
        $this->assertEquals('BlackPepperChicken.jpg', $subItem['item']->gallery);

        // product information
        $this->assertEquals(15, $item['productItem']->id);  // Product: id, name, price, description, gallery, category
        $this->assertEquals('Party Tray', $item['productItem']->name);
        $this->assertEquals(23.99, $item['productItem']->price);
        $this->assertEquals('3 sides & 3 large entrees', $item['productItem']->description);
        $this->assertEquals('PartyTray.jpg', $item['productItem']->gallery);
        $this->assertEquals('', $item['productItem']->category);
    }

    public function test_add_kids_meal()
    {
        $productId = 16;
        $quantity = 1;
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $sideItem = array('category'=>'Side', 'id'=>2, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $drinkItem = array('category'=>'Drink', 'id'=>2, 'quantity'=>1);
        array_push($subItems, $drinkItem);

        $expect = '~<span id="cart_count" class="text-warning bg-light">1</span>~';
        $this->expectOutputRegex($expect);
        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        // Cart Class: $serialNumber, $items, $totalQuantity, $totalPrice, $note, $created, $orderId
        $serialNumber = Session::get('cart')->serialNumber;
        $this->assertEquals(1, $serialNumber);
        $items = Session::get('cart')->items;
        $this->assertEquals(1, count($items));
        $totalQuantity = Session::get('cart')->totalQuantity;
        $this->assertEquals(1, $totalQuantity);
        $totalPrice = Session::get('cart')->totalPrice;
        $this->assertEquals(5.74, $totalPrice);
        $note = Session::get('cart')->note;
        $this->assertEquals('', $note);
        $created = Session::get('cart')->created;
        $this->assertEquals(null, $created);
        $orderId = Session::get('cart')->orderId;
        $this->assertEquals(null, $orderId);

        // items: Appetizers, combos, drinks, single sides/entrees
        // each item is different after merging same appetizer, combo, drink or single side/entree
        $item = Session::get('cart')->items[1]; // The number: 1 is from $serialNumber, each $item includes: productItem, subItems, quantity, and totalPricePerProductItem. See: addNewItem method in Cart.php
        $productItem = $item['productItem'];
        $this->assertEquals(16, $productItem->id);
        $this->assertEquals(4, count($item['subItems']));
        $this->assertEquals(1, $item['quantity']);
        $this->assertEquals(5.74, $item['totalPricePerProductItem']);   // Calculate unit price if there is extra charge like Kid's meal with bottle water which has extra charge $0.75

        // subItems: Side 1 information
        $subItem = $item['subItems'][0];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Side', $subItem['category']);
        $this->assertEquals(0.5, $subItem['quantity']);
        $this->assertEquals(1, $subItem['item']->id);   // Side: id, name, description, gallery
        $this->assertEquals('Fried Rice', $subItem['item']->name);
        $this->assertEquals('Fried rice with some vegetable and soy source', $subItem['item']->description);
        $this->assertEquals('FriedRice.jpg', $subItem['item']->gallery);
        // subItems: Side 2 information
        $subItem = $item['subItems'][1];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Side', $subItem['category']);
        $this->assertEquals(0.5, $subItem['quantity']);
        $this->assertEquals(2, $subItem['item']->id);   // Side: id, name, description, gallery
        $this->assertEquals('Chow Mein', $subItem['item']->name);
        $this->assertEquals('Chow mein with some vegetable', $subItem['item']->description);
        $this->assertEquals('ChowMein.jpg', $subItem['item']->gallery);
        // subItems: Entree 1 information
        $subItem = $item['subItems'][2];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Entree', $subItem['category']);
        $this->assertEquals(1, $subItem['quantity']);
        $this->assertEquals(1, $subItem['item']->id);   // Entree: id, name, description, gallery
        $this->assertEquals('BBQ Chicken', $subItem['item']->name);
        $this->assertEquals('BBQ chicken entree', $subItem['item']->description);
        $this->assertEquals('BBQChicken.jpg', $subItem['item']->gallery);
        // subItems: Drink 1 information
        $subItem = $item['subItems'][3];    // Each $subItem includes: category, item(side, entry, drink object - this is converted from id to object See: processSubItems method in Cart.php), quantity, selectBoxId
        $this->assertEquals('Drink', $subItem['category']);
        $this->assertEquals(1, $subItem['quantity']);
        $this->assertEquals(2, $subItem['item']->id);   // Entree: id, name, description, gallery
        $this->assertEquals('Bottle Water', $subItem['item']->name);
        $this->assertEquals("Bottle water for kid's meal", $subItem['item']->description);
        $this->assertEquals('BottleWater.jpg', $subItem['item']->gallery);

        // product information
        $this->assertEquals(16, $item['productItem']->id);  // Product: id, name, price, description, gallery, category
        $this->assertEquals("Kid's Meal", $item['productItem']->name);
        $this->assertEquals(4.99, $item['productItem']->price);
        $this->assertEquals('One small drink, one side and one entree', $item['productItem']->description);
        $this->assertEquals('KidsMeal.jpg', $item['productItem']->gallery);
        $this->assertEquals('', $item['productItem']->category);
    }

    public function test_add_regular_platter_with_wrong_side_quantity()
    {
        $productId = 13;
        $quantity = 2;
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>2);  // 'quantity' should be 1
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>2);
        array_push($subItems, $entreeItem);

        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);
        $status = $response->json()['status'];
        $this->assertEquals(0, $status);
        $message = $response->json()['message'];
        $this->assertEquals('Please select side and entree before you add order to cart.', $message);
    }

    public function test_retrieveQuantityOfSubItems()
    {
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $sideItem = array('category'=>'Side', 'id'=>2, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $drinkItem = array('category'=>'Drink', 'id'=>2, 'quantity'=>1);
        array_push($subItems, $drinkItem);
        
        $controller = new OrderController();
        $quantityOfSubItems = $controller->retrieveQuantityOfSubItems($subItems);
        $this->assertEquals(1, $quantityOfSubItems['Side']);
        $this->assertEquals(1, $quantityOfSubItems['Entree']);
        $this->assertEquals(1, $quantityOfSubItems['Drink']);
    }

    public function test_validateSideAndEntreeAndDrink_failed()
    {
        $productId = 16;
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $sideItem = array('category'=>'Side', 'id'=>2, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $drinkItem = array('category'=>'Drink', 'id'=>2, 'quantity'=>2);
        array_push($subItems, $drinkItem);

        $controller = new OrderController();
        $pass = $controller->validateSideAndEntreeAndDrink($productId, $subItems);
        $this->assertFalse($pass);
    }

    public function test_validateSideAndEntreeAndDrink_success()
    {
        $productId = 16;
        $subItems = array();
        $sideItem = array('category'=>'Side', 'id'=>1, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $sideItem = array('category'=>'Side', 'id'=>2, 'quantity'=>0.5);
        array_push($subItems, $sideItem);
        $entreeItem = array('category'=>'Entree', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $entreeItem);
        $drinkItem = array('category'=>'Drink', 'id'=>2, 'quantity'=>1);
        array_push($subItems, $drinkItem);

        $controller = new OrderController();
        $pass = $controller->validateSideAndEntreeAndDrink($productId, $subItems);
        $this->assertTrue($pass);
    }
}
