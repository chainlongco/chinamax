<?php

namespace Tests\Feature\Http\Controllers\Menu;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Http\Menu;
use App\Http\Product;
use App\Http\Single;

class MenuTest extends TestCase
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
                'description'=>'Small Size of beef entree',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Beef'],
            ['name'=>'Regular Beef',
                'price'=>'6.49',
                'description'=>'Regular Size of beef entree',
                'gallery'=>'',
                'menu_id'=>'4',
                'category'=>'Beef'],
            ['name'=>'Large Beef',
                'price'=>'6.99',
                'description'=>'Small Size of beef entree',
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

    // menu() method
    public function test_menu()
    {
        $response = $this->call('GET', '/menu');
        $response->assertStatus(200);

        $response->assertSee('Menu');
        $response->assertSeeInOrder(['Menu', 'Combo', 'Side & Entree combination', 'Small Platter', 'Any 1 side & 1 entree -- ']);
        //$response->assertSeeInOrder(['Menu', 'Combo', 'Side & Entree combination', 'Small Platter', 'Any 1 side & 1 entree -- $']);   Do not know why with $ at the end NOT Working. But it works $ in the beginning.
        $response->assertSeeInOrder(['$6.4', 'Regular Platter', 'Any 1 side & 2 entrees -- ']);
        $response->assertSeeInOrder(['$7.58', 'Large Platter', 'Any 1 side & 3 entrees -- ']);
        $response->assertSeeInOrder(['$8.93', 'Party Tray', '3 sides & 3 large entrees -- ']);
        $response->assertSeeInOrder(['$23.99', "Kid's Meal"]);
        $response->assertSeeInOrder(['One small drink, one side and one entree -- ']);
        $response->assertSeeInOrder(['$4.99', 'Appetizers', 'A small dish before main meal', 'Drinks', 'Water, Fresh Juice, Soft Drinks...']);
        $response->assertSeeInOrder(['Individual Side/Entree', 'Side or Entree only', 'Side', 'Select different size of side', 'Chicken Entree', 'Select different size of chicken entree', 'Beef Entree', 'Select different size of beef entree', 'Shrimp Entree', 'Select different size of shrimp entree']);
    }

    // orderChoices(Request $request) method
    public function test_choice_for_combo_regular_platter()
    {
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);
        $response->assertStatus(200);

        /* Combo -- Regular Platter */
        $expected = '';
        $expected .= '~Choices for Regular Platter~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        /* Sides */
        $expected = '';
        $expected .= '~Choose 1 Side ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~(or Half/Half)~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Fried Rice~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Chow Mein~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Steam White Rice~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        /* Entrees */
        $expected = '';
        $expected .= '~Choose 2 Entrees~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        /* Chicken */
        $expected = '';
        $expected .= '~Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~BBQ Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Black Pepper Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~General Taos Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Jalapeno Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Kung Pao Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Mushroom Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Orange Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~String Bean Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Teriyaki Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        /* Beef */
        $expected = '';
        $expected .= '~Beef~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Beef Broccoli~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);
        
        $expected = '';
        $expected .= '~Hunan Beef~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Pepper Steak~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        /* Shrimp */
        $expected = '';
        $expected .= '~Shrimp~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Broccoli Shrimp~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        $expected = '';
        $expected .= '~Kung Pao Shrimp~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);

        /* - 1 + Add to Cart */
        $expected = '';
        $expected .= '~<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus14"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity14" disabled><button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus14"><i class="fas fa-plus"></i></button></div></div><br></div><div class="col-md-4 my-auto"><div class="quantityDiv mx-auto"><button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus13"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity13" disabled style="margin: 0px 10px"><button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus13"><i class="fas fa-plus"></i></button></div><div><br><button type="button" class="btn bg-light border addToCartForCombo" disabled id="addToCartForCombo13">Add to Cart</button>~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'13p']);
    }

    // orderChoices(Request $request) method
    public function test_choice_for_combo_small_platter()
    {
        $response = $this->call('GET', '/order-choices', ['menuId'=>'12p']);
        $response->assertStatus(200);

        /* Combo -- Small Platter */
        $expected = '';
        $expected .= '~Choices for Regular Platter~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'12p']);

        /* Sides */
        $expected = '';
        $expected .= '~Choose 1 Side ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'12p']);

        $expected = '';
        $expected .= '~(or Half/Half)~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'12p']);

        /* Entree */
        $expected = '';
        $expected .= '~Choose 1 Entree ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'12p']);

        $expected = '';
        $expected .= '~Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'12p']);

        $expected = '';
        $expected .= '~Beef~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'12p']);

        $expected = '';
        $expected .= '~Shrimp~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'12p']);

        /* - 1 + Add to Cart */
        $expected = '';
        $expected .= '~<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus14"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity14" disabled><button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus14"><i class="fas fa-plus"></i></button></div></div><br></div><div class="col-md-4 my-auto"><div class="quantityDiv mx-auto"><button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus12"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity12" disabled style="margin: 0px 10px"><button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus12"><i class="fas fa-plus"></i></button></div><div><br><button type="button" class="btn bg-light border addToCartForCombo" disabled id="addToCartForCombo12">Add to Cart</button>~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'12p']);
    }

    // orderChoices(Request $request) method
    public function test_choice_for_combo_large_platter()
    {
        $response = $this->call('GET', '/order-choices', ['menuId'=>'14p']);
        $response->assertStatus(200);

        /* Combo -- Large Platter */
        $expected = '';
        $expected .= '~Choices for Large Platter~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'14p']);

        /* Sides */
        $expected = '';
        $expected .= '~Choose 1 Side ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'14p']);

        $expected = '';
        $expected .= '~(or Half/Half)~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'14p']);

        /* Entree */
        $expected = '';
        $expected .= '~Choose 3 Entrees ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'14p']);

        $expected = '';
        $expected .= '~Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'14p']);

        $expected = '';
        $expected .= '~Beef~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'14p']);

        $expected = '';
        $expected .= '~Shrimp~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'14p']);

        /* - 1 + Add to Cart */
        $expected = '';
        $expected .= '~<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus14"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity14" disabled><button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus14"><i class="fas fa-plus"></i></button></div></div><br></div><div class="col-md-4 my-auto"><div class="quantityDiv mx-auto"><button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus14"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity14" disabled style="margin: 0px 10px"><button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus14"><i class="fas fa-plus"></i></button></div><div><br><button type="button" class="btn bg-light border addToCartForCombo" disabled id="addToCartForCombo14">Add to Cart</button>~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'14p']);
    }

    // orderChoices(Request $request) method
    public function test_choice_for_combo_party_tray()
    {
        $response = $this->call('GET', '/order-choices', ['menuId'=>'15p']);
        $response->assertStatus(200);

        /* Combo -- Large Platter */
        $expected = '';
        $expected .= '~Choices for Party Tray~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'15p']);

        /* Sides */
        $expected = '';
        $expected .= '~Choose 3 Sides ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'15p']);

        /* Entree */
        $expected = '';
        $expected .= '~Choose 3 Entrees ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'15p']);

        $expected = '';
        $expected .= '~Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'15p']);

        $expected = '';
        $expected .= '~Beef~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'15p']);

        $expected = '';
        $expected .= '~Shrimp~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'15p']);

        /* - 1 + Add to Cart */
        $expected = '';
        $expected .= '~<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus14"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity14" disabled><button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus14"><i class="fas fa-plus"></i></button></div></div><br></div><div class="col-md-4 my-auto"><div class="quantityDiv mx-auto"><button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus15"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity15" disabled style="margin: 0px 10px"><button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus15"><i class="fas fa-plus"></i></button></div><div><br><button type="button" class="btn bg-light border addToCartForCombo" disabled id="addToCartForCombo15">Add to Cart</button>~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'15p']);
    }

    // orderChoices(Request $request) method
    public function test_choice_for_combo_kids_meal()
    {
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);
        $response->assertStatus(200);

        /* Combo -- Large Platter */
        $expected = '';
        $expected .= '~Choices for Party Tray~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        /* Side */
        $expected = '';
        $expected .= '~Choose 1 Side ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        $expected = '';
        $expected .= '~(or Half/Half)~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        /* Entree */
        $expected = '';
        $expected .= '~Choose 1 Entree ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        $expected = '';
        $expected .= '~Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        $expected = '';
        $expected .= '~Beef~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        $expected = '';
        $expected .= '~Shrimp~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        /* Drink */
        $expected = '';
        $expected .= '~Choose 1 Drink~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        $expected = '';
        $expected .= '~(Default: Small Fountain Drink)~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        $expected = '';
        $expected .= '~Small Drink~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        $expected = '';
        $expected .= '~Choose the flavor~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        $expected = '';
        $expected .= '~Bottle Water - Extra Charge: $0.75~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);

        $expected = '';
        $expected .= '~<button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus16"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity16" disabled style="margin: 0px 10px"><button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus16"><i class="fas fa-plus"></i></button></div><div><br><button type="button" class="btn bg-light border addToCartForCombo" disabled id="addToCartForCombo16">Add to Cart</button></div></div></div>~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'16p']);
    }


    // orderChoices(Request $request) method
    public function test_choice_for_Appetizers()
    {
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);
        $response->assertStatus(200);

        $expected = '';
        $expected .= '~Choices for Appetizers~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);

        /* Egg Roll */
        $expected = '';
        $expected .= '~Egg Roll~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);

        $expected = '';
        $expected .= '~(5)~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);

        $expected = '';
        $expected .= '~$4.59~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);

        /* Crab Rangoon */
        $expected = '';
        $expected .= '~Crab Rangoon~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);

        $expected = '';
        $expected .= '~(6)~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);

        $expected = '';
        $expected .= '~3.99~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);

        /* Fried Dumpling */
        $expected = '';
        $expected .= '~Fried Dumpling~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);

        $expected = '';
        $expected .= '~(5)~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);

        $expected = '';
        $expected .= '~3.95~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);

        /* - 0 + Add to Cart */
        $expected = '';
        $expected .= '~<button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus3"><i class="fas fa-minus"></i></button>~';
        $this->expectOutputRegex($expected);
        $expected = '';
        $expected .= '~<input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity3" disabled>~';
        $expected = '';
        $expected .= '~<button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus3"><i class="fas fa-plus"></i></button>~';
        $this->expectOutputRegex($expected);
        $expected = '';
        $expected .= '~<button type="button" class="btn bg-light border addToCart" disabled id="addToCart3">Add to Cart</button>~';
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1']);
    }

    // orderChoices(Request $request) method
    public function test_choice_for_Drinks()
    {
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);
        $response->assertStatus(200);

        $expected = '';
        $expected .= '~Choices for Drinks~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        /* Water */
        $expected = '';
        $expected .= '~Water~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        $expected = '';
        $expected .= '~$0.00~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        /* Water */
        $expected = '';
        $expected .= '~Bottle Water~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        $expected = '';
        $expected .= '~1.50~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        /* Canned Drink */
        $expected = '';
        $expected .= '~Canned Drink -- $1.25~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        $expected = '';
        $expected .= '~Choose the flavor~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        /* Fountain Drink */
        $expected = '';
        $expected .= '~Fountain Drink~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        $expected = '';
        $expected .= '~Choose the flavor~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        $expected = '';
        $expected .= '~Fountain Soft Drink Small - ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        $expected = '';
        $expected .= '~$3.99~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        /* Fresh Juice */
        $expected = '';
        $expected .= '~Fresh Juice~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        $expected = '';
        $expected .= '~Choose the flavor~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        $expected = '';
        $expected .= '~Small Fresh Fruit Juice - ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        $expected = '';
        $expected .= '~3.99~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);

        /* - 0 + Add to Cart */
        $expected = '';
        $expected .= '~<div class="quantityDiv mx-auto"><button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus5"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity5" disabled><button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus5"><i class="fas fa-plus"></i></button></div><div><button type="button" class="btn bg-light border addToCartForDrinkOnly" id="addToCartForDrinkOnly5" disabled>Add to Cart</button></div>~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2']);
    }

    // orderChoices(Request $request) method
    public function test_choice_for_side_of_individual_side_entree()
    {
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1s', 'mainMenuId'=>'4']);
        $response->assertStatus(200);

        $expected = '';
        $expected .= '~Choices for Side~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1s', 'mainMenuId'=>'4']);

        /* Fried Rice */
        $expected = '';
        $expected .= '~Fried Rice~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1s', 'mainMenuId'=>'4']);

        $expected = '';
        $expected .= '~Small Side - ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1s', 'mainMenuId'=>'4']);

        $expected = '';
        $expected .= '~2.49~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1s', 'mainMenuId'=>'4']);

        /* Chow Mein */
        $expected = '';
        $expected .= '~Chow Mein~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1s', 'mainMenuId'=>'4']);

        /* Steam White Rice */
        $expected = '';
        $expected .= '~Steam White Rice~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1s', 'mainMenuId'=>'4']);

        /* - 0 + Add to Cart */
        $expected = '';
        $expected .= '~<div class="quantityDiv mx-auto"><button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus3"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity3" disabled><button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus3"><i class="fas fa-plus"></i></button></div><div><button type="button" class="btn bg-light border addToCartForSide" id="addToCartForSide3" disabled>Add to Cart</button></div></div><br></div></div>~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'1s', 'mainMenuId'=>'4']);
    }

    // orderChoices(Request $request) method
    public function test_choice_for_chicken_entree_of_individual_side_entree()
    {
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2s', 'mainMenuId'=>'4']);
        $response->assertStatus(200);

        $expected = '';
        $expected .= '~Choices for Chicken Entree~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2s', 'mainMenuId'=>'4']);

        /* BBQ Chicken */
        $expected = '';
        $expected .= '~BBQ Chicken~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2s', 'mainMenuId'=>'4']);

        $expected = '';
        $expected .= '~Small Chicken - ~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2s', 'mainMenuId'=>'4']);

        $expected = '';
        $expected .= '~5.49~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2s', 'mainMenuId'=>'4']);

        /* - 0 + Add to Cart */
        $expected = '';
        $expected .= '~<button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus9"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity9" disabled><button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus9"><i class="fas fa-plus"></i></button></div><div><button type="button" class="btn bg-light border addToCartForEntree" id="addToCartForEntree9" disabled>Add to Cart</button></div></div><br></div></div>~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'2s', 'mainMenuId'=>'4']);
    }

    // orderChoices(Request $request) method
    public function test_choice_for_Beef_entree_of_individual_side_entree()
    {
        $response = $this->call('GET', '/order-choices', ['menuId'=>'3s', 'mainMenuId'=>'4']);
        $response->assertStatus(200);

        $expected = '';
        $expected .= '~Choices for Beef Entree~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'3s', 'mainMenuId'=>'4']);

        // Beef Broccoli
        $expected = '';
        $expected .= '~Beef Broccoli~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'3s', 'mainMenuId'=>'4']);

        $expected = '';
        $expected .= '~Small Beef - $5.99~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'3s', 'mainMenuId'=>'4']);

        /* - 1 + Add to Cart */
        $expected = '';
        $expected .= '~<button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus12"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity12" disabled><button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus12"><i class="fas fa-plus"></i></button></div><div><button type="button" class="btn bg-light border addToCartForEntree" id="addToCartForEntree12" disabled>Add to Cart</button></div></div><br></div></div>~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'3s', 'mainMenuId'=>'4']);
    }
    

    // orderChoices(Request $request) method
    public function test_choice_for_Shrimp_entree_of_individual_side_entree()
    {
        $response = $this->call('GET', '/order-choices', ['menuId'=>'4s', 'mainMenuId'=>'4']);
        $response->assertStatus(200);

        $expected = '';
        $expected .= '~Choices for Shrimp Entree~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'4s', 'mainMenuId'=>'4']);

        // Beef Broccoli
        $expected = '';
        $expected .= '~Broccoli Shrimp~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'4s', 'mainMenuId'=>'4']);

        $expected = '';
        $expected .= '~Small Shrimp - $6.49~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'4s', 'mainMenuId'=>'4']);

        /* - 1 + Add to Cart */
        $expected = '';
        $expected .= '~<button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus14"><i class="fas fa-minus"></i></button><input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity14" disabled><button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus14"><i class="fas fa-plus"></i></button></div><div><button type="button" class="btn bg-light border addToCartForEntree" id="addToCartForEntree14" disabled>Add to Cart</button></div></div><br></div></div>~';                        
        $this->expectOutputRegex($expected);
        $response = $this->call('GET', '/order-choices', ['menuId'=>'4s', 'mainMenuId'=>'4']);
    }
}
