<?php

namespace Tests\Feature\Http\Shared;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Single;
use App\Http\Controllers\OrderController;
use App\Shared\Utility;

class UtilityTest extends TestCase
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

    public function test_cartElement_for_image_without_subItem()
    {
        $productId = 4;
        $quantity = 1;
        $subItems = array();
        $drinkItem = array('category'=>'DrinkOnly', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $drinkItem);

        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('GET', '/cart');
        $response->assertSee('Water.jpg');
    }

    public function test_cartElement_for_image_with_subItem()
    {
        $productId = 6;
        $quantity = 1;
        $subItems = array();
        $drinkItem = array('category'=>'DrinkOnly', 'id'=>3, 'quantity'=>1, 'selectBoxId'=>1);
        array_push($subItems, $drinkItem);

        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $response = $this->call('GET', '/cart');
        $response->assertSee('SoftDrinkCan.jpg');
    }

    public function test_orderListDivElementForCheckout_for_kids_meal()
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

        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $expected = "~KidsMeal.jpg~";
        $this->expectOutputRegex($expected);
        $utility = new Utility();
        $response = $utility->orderListDivElementForCheckout();
    }

    public function test_cartElementForCheckout_for_product_gallery_is_empty()
    {
        $productId = 4;
        $quantity = 1;
        $subItems = array();
        $drinkItem = array('category'=>'DrinkOnly', 'id'=>1, 'quantity'=>1);
        array_push($subItems, $drinkItem);

        $response = $this->call('GET', '/order-added', ['productId'=>$productId, 'quantity'=>$quantity, 'subItems'=>json_encode($subItems)]);
        $response->assertStatus(200);

        $expected = "~Water.jpg~";
        $this->expectOutputRegex($expected);
        $utility = new Utility();
        $response = $utility->orderListDivElementForCheckout();
    }

    public function test_orderNoteDivElementForCheckout_for_note_in_cart()
    {
        $response = $this->call('GET', '/cart-note', ['note'=>"Add new note test"]);
        $response->assertStatus(200);
        $note = Session::get('cart')->note;
        $this->assertEquals('Add new note test', $note);

        $expected = "~Add new note test~";
        $this->expectOutputRegex($expected);
        $utility = new Utility();
        $response = $utility->orderNoteDivElementForCheckout();
    }
}
