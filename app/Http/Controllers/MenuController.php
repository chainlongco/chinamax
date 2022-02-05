<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function menu() {
        /* Build the menu: 
            1. Appetizers: No sub-menu, directly displays appetizers choices from products table. Then, choices load individual appetizer with 1. Quantity Increment/Decrement buttons 2. Add to Cart button
            2. Drinks: Retrieving drinks from drinks table to load choices (water, fountain drink, canned drink and juice) - each drink has 1. select box for size and price which from products table, 2. choices select box (like sprit, coke...), 3. Quantity Increment/Decrement buttons, 4. Add to Cart button
            3. Combo: Has sub-menu, sub-menus are from products table. Then, choices load 1. sides, 2. entrees 3. drinks 4. Quantity Increment/Decrement buttons 5. Add to Cart button
            4. Individual Side/Entree: Has sub-menu, sub-menus are from singles table. Then choices load side/entree(chicken, beef, shrimp) choices with 1. Select size with price 1. Quantity Increment/Decrement buttons,   2. Add to Cart button 
        */
        $menus = DB::table('menus')->where('level', 0)->get();
        
        // For Combo
        $menuCombo = DB::table('menus')->where('name', 'Combo')->first();
        $products = DB::table('products')->where('menu_id', $menuCombo->id)->get();
        $comboArray = array('menu'=>$menuCombo, 'products'=>$products);

        // For Individual Side/Entree
        $menuIndividual = DB::table('menus')->where('name', 'Individual Side/Entree')->first();
        $singles = DB::table('singles')->get();
        $singleArray = array('menu'=>$menuIndividual, 'singles'=>$singles);

        return view('order', compact('menus', 'comboArray', 'singleArray'));


        // For Drinks
        /*$drinks = DB::table('drinks')->get();
        $cans = DB::table('cans')->get();
        return view('order', compact('menus', 'comboArray', 'singleArray', 'drinks', 'cans'));*/

        /*  For Individual Side/Entree
        $sides = DB::table('sides')->get();
        $productSides = DB::table('products')->where('menu_id', $menuIndividual->id)->where('category', 'Side')->get();
        return view('order', compact('menus', 'comboArray', 'singleArray', 'sides', 'productSides'));*/

        /* 
        $level1s = DB::table('menus')->where('level', 1)->get();
        $level1Arrays = array();
        foreach ($level1s as $level) {
            $products = DB::table('products')->where('menu_id', $level->id)->get();
            $level1Arrays[$level->id] = ['menu'=>$level, 'products'=>$products];
        }
        return view('order', compact('menus', 'level1Arrays'));*/

        // Kid's Meal
        /*$product = DB::table('products')->where('id', 16)->first();
        $productFountain = DB::table('products')->where('id', 29)->first();
        $fountains = DB::table('fountains')->get();
        return view('order', compact('menus', 'level1Arrays', 'product', 'productFountain', 'fountains'));*/


        // Old Menu
        /*$menus = DB::table('menus')->where('level', 0)->get();
        $level1s = DB::table('menus')->select('id')->where('level', 1)->get();
        $ids = array();
        foreach ($level1s as $level) {
            array_push($ids, $level->id);
        }
        $products = DB::table('products')->whereIn('menu_id', $ids)->get();
        return view('order', compact('menus', 'products'));*/


        /*$product1 = DB::table('products')->where('id', 13)->first();
        $sides = DB::table('sides')->get();
        $chickenEntrees = DB::table('entrees')->where('category', 'Chicken')->get();
        $beefEntrees = DB::table('entrees')->where('category', 'Beef')->get();
        $shrimpEntrees = DB::table('entrees')->where('category', 'Shrimp')->get();
        return view('order', compact('menus', 'products', 'sides', 'chickenEntrees', 'beefEntrees', 'shrimpEntrees', 'product1'));*/
    }

    public function orderChoices(Request $request)
    {   // ToDo -- Needs to rewrite.......
        $menuId = $request->menuId;
        $mainMenuId = $request->mainMenuId;
        $menuName = "";
        $menu = null;
        $product = null;
        $single = null;
        if (str_contains($menuId, 'p')) {   // From Products table -- Small Platter, Regular Platter, Large Platter, Kid's Meal, Party Tray
            $productId = substr($menuId, 0, (strlen($menuId) -1));
            $product = DB::table('products')->where('id', $productId)->first();
            $menuName = $product->name;
        } else if (str_contains($menuId, 's')) {     // from Singles table -- for Individual Side/Entree
            $singleId = substr($menuId, 0, (strlen($menuId) -1));
            $single = DB::table('singles')->where('id', $singleId)->first();
            $menuName = $single->name;
        } else {    // from Menus table -- for Appetizer, Drink, Individual Side/Entree  
            $menu = DB::table('menus')->where('id', $menuId)->first();
            $menuName = $menu->name;
        }

        if ($menuName === "Appetizers") {   // For Appetizers
            echo $this->loadAppetizesChoices($menu);
        } else if ($menuName === "Small Platter") { // For Combo
            echo $this->loadComboChoices($product);
        } else if ($menuName === "Regular Platter") {   // For Combo
            echo $this->loadComboChoices($product);
        } else if ($menuName === "Large Platter") { // For Combo
            echo $this->loadComboChoices($product);
        } else if ($menuName === "Party Tray") {    // For Combo
            echo $this->loadComboChoices($product);
        } else if ($menuName === "Kid's Meal") {    // For Combo
            echo $this->loadComboChoices($product);
        } else if ($menuName === "Side"){   // For Individual Side/Entree
            echo $this->loadIndividualSideChoices($single, $mainMenuId);
        } else if ($menuName === "Chicken Entree"){   // For Individual Side/Entree
            echo $this->loadIndividualEntreeChoices($single, $mainMenuId, "Chicken");
        } else if ($menuName === "Beef Entree"){   // For Individual Side/Entree
            echo $this->loadIndividualEntreeChoices($single, $mainMenuId, "Beef");
        } else if ($menuName === "Shrimp Entree"){   // For Individual Side/Entree
            echo $this->loadIndividualEntreeChoices($single, $mainMenuId, "Shrimp");
        } else if ($menuName === "Drinks") {  //For Drink
            echo $this->loadDrinksChoices($menuName);
        }
    }

    protected function loadAppetizesChoices($menu)
    {
        $quantity = 0;
        $html = "";
        $products = DB::table('products')->where('menu_id', $menu->id)->get();
        $html .= "<h1>Choices for " .$menu->name ."</h1>";
        $html .= "<div class=\"row\">";
        foreach ($products as $product) {
            $html .= "<div class=\"col-md-4 text-center\">";
                $html .= "<div class=\"choiceItem\">";
                    $html .= "<img src=\"\\images\\" .$product->gallery ."\" style=\"width:60%\">";
                    $html .= "<br>";
                    $html .= "<span class=\"choiceItemName\">" .$product->name ."</span>";
                    $html .= "<br>";
                    $html .= "<span class=\"choiceItemPrice\">$" .$product->price ."</span>";
                    $html .= "<br>";
                    $html .= "<div class=\"quantityDiv mx-auto\">
                                <button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$product->id ."\"><i class=\"fas fa-minus\"></i></button>
                                <input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"" .$quantity ."\" id=\"quantity" .$product->id ."\" disabled>
                                <button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$product->id ."\"><i class=\"fas fa-plus\"></i></button>
                            </div>";
                    $html .= "<div>
                                <button type=\"button\" class=\"btn bg-light border addToCart\" disabled id=\"addToCart" .$product->id ."\">Add to Cart</button>
                            </div>";          
                $html .= "</div>";
            $html .= "</div>";
        }
        
        $html .= "</div>";
        return $html;

        /*
        <div class="row">
            @foreach($appetizers as $appetizer)
            <div class="col-md-4 text-center">
                <div class="choiceItem">
                    <img src="\images\{{ $appetizer->gallery }}" style="width:60%">
                    <br>
                    <span class="choiceItemName">{{ $appetizer->name }}</span>
                    <br>
                    <span class="choiceItemPrice">${{ $appetizer->price }}</span>
                </div>
            </div>
            @endforeach
        </div>*/
    }

    protected function loadDrinksChoices($menuName)
    {
        $html = "";

        $drinks = DB::table('drinks')->get();
        $html .= "<h1>Choices for " .$menuName ."</h1>";
        $html .= "<div class=\"row\">";
                    foreach ($drinks as $drink) {
                        $productDrinks = DB::table('products')->where('category', $drink->name)->get();
                        if (count($productDrinks)==1) {
                            $productDrink = $productDrinks[0];
        $html .=            "<div class=\"col-md-4 text-center\">";
        $html .=                "<div class=\"choiceItemDrink\" id=\"choiceItemDrink" .$drink->id ."\">";
        $html .=                    "<input type=\"hidden\" id=\"productId" .$drink->id ."\" value=\"" .$productDrink->id ."\"/>";
        $html .=                    "<img src=\"\\images\\" .$drink->gallery ."\" style=\"width:60%\">";
        $html .=                    "<br>";
                                    $tableName = $drink->tablename;
                                    $price = number_format($productDrink->price, 2, '.', ',');
                                    if ($tableName!="") {
        $html .=                        "<span class=\"choiceItemDrinkName\" id=\"choiceItemDrinkName" .$drink->id ."\">" .$drink->name ." -- $" .$price ."</span>";
        $html .=                        "<div style=\"padding-top:10px; font-size:20px;\">";
        $html .=                            "<select name=\"selectDrink\" class=\"selectDrink\" id=\"selectDrink" .$drink->id ."\" style=\"height: 37px; padding: 0px 10px; \">";
        $html .=                                "<option value=0 selected disable>Choose the flavor</option>";
                                                $drinkLists = DB::table($tableName)->get(); // this is for cans table
                                                foreach ($drinkLists as $drinkList) {
        $html .=                                    "<option value=" .$drinkList->id .">" .$drinkList->name ."</option>";
                                                }
        $html .=                            "</select>";
        $html .=                        "</div>";
                                    } else {
        $html .=                        "<span class=\"choiceItemDrinkName\" id=\"choiceItemDrinkName" .$drink->id ."\">" .$drink->name ."</span>";
        $html .=                        "<br>";
        $html .=                        "<span class=\"choiceItemPrice\">$" .$price ."</span>";
        $html .=                        "<br>";
                                    }
        $html .=                    "<div class=\"quantityDiv mx-auto\">";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$drink->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                        "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"0\" id=\"quantity" .$drink->id ."\" disabled>";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$drink->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                    "</div>";
        $html .=                    "<div>";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border addToCartForDrinkOnly\" id=\"addToCartForDrinkOnly" .$drink->id ."\" disabled>Add to Cart</button>";
        $html .=                    "</div>";
        $html .=                "</div>";
        $html .=                "<br>";
        $html .=            "</div>";
                        } else {
                            $tableName = $drink->tablename;           
        $html .=            "<div class=\"col-md-4 text-center\">";
        $html .=                "<div class=\"choiceItemDrink\" id=\"choiceItemDrink" .$drink->id ."\">";
        $html .=                    "<img src=\"\\images\\" .$drink->gallery ."\" style=\"width:60%\">";
        $html .=                    "<br>"; 
        $html .=                    "<span class=\"choiceItemDrinkName\" id=\"choiceItemDrinkName" .$drink->id ."\">" .$drink->name ."</span>";
        $html .=                    "<div style=\"padding-top:10px; font-size:20px;\">";
        $html .=                        "<select name=\"selectDrink\" class=\"selectDrink\" id=\"selectDrink" .$drink->id ."\" style=\"height: 37px; padding: 0px 10px; \">";
        $html .=                            "<option value=0 selected disable>Choose the flavor</option>";                                                
                                            $drinkLists = DB::table($tableName)->get(); // this is for fountains and juices table
                                            foreach ($drinkLists as $drinkList) {                                                     
        $html .=                                "<option value=" .$drinkList->id .">" .$drinkList->name ."</option>";
                                            }
        $html .=                        "</select>";
        $html .=                    "</div>";
        $html .=                    "<div style=\"padding-top:10px; font-size:20px;\">";
        $html .=                        "<select name=\"productDrinks\" id=\"productDrinks" .$drink->id ."\" style=\"height: 37px; padding: 0px 10px; \">";
                                            foreach ($productDrinks as $productDrink) {
        $html .=                                "<option value=" .$productDrink->id ."\">" .$productDrink->name ." - $" .$productDrink->price ."</option>";
                                            }
        $html .=                        "</select>";
        $html .=                    "</div>";
        $html .=                    "<div class=\"quantityDiv mx-auto\">";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$drink->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                        "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"0\" id=\"quantity" .$drink->id ."\" disabled>";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$drink->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                    "</div>";
        $html .=                    "<div>";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border addToCartForDrinkOnly\" id=\"addToCartForDrinkOnly" .$drink->id ."\" disabled>Add to Cart</button>";
        $html .=                    "</div>";
        $html .=                "</div>";
        $html .=                "<br>";
        $html .=            "</div>";  
                        }
                    }
        $html .= "</div>";

        return $html;


                    /*<h1>Choices for Drink</h1>
                    <div class="row">
                        <?php
                            foreach ($drinks as $drink) {
                                $productDrinks = DB::table('products')->where('category', $drink->name)->get();
                                if (count($productDrinks)==1) {
                                    $productDrink = $productDrinks[0];
                        ?>
                                    <div class="col-md-4 text-center">
                                        <div class="choiceItemDrink" id="choiceItemDrink{{ $drink->id }}">
                                            <input type="hidden" id="productId{{ $drink->id }}" value="{{ $productDrink->id }}"/>
                                            <img src="\images\{{ $drink->gallery }}" style="width:60%">
                                            <br>
                                            
                                            <?php
                                                $tableName = $drink->tablename;
                                                $price = number_format($productDrink->price, 2, '.', ',');
                                                if ($tableName!="") {
                                            ?>

                                                    <span class="choiceItemDrinkName" id="choiceItemDrinkName{{ $drink->id }}">{{ $drink->name }} -- ${{ $price }}</span>
                                                    <div style="padding-top:10px; font-size:20px;">
                                                        <select name="selectDrink" class="selectDrink" id="selectDrink{{ $drink->id }}" style="height: 37px; padding: 0px 10px; ">
                                                            <option value=0 selected disable>Choose the flavor</option>
                                                            <?php
                                                                $drinkLists = DB::table($tableName)->get(); // this is for cans table
                                                                foreach ($drinkLists as $drinkList) {
                                                            ?>        
                                                                    <option value={{ $drinkList->id }}>{{ $drinkList->name }}</option>
                                                            <?php
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>

                                            <?php
                                                } else {
                                            ?>

                                                <span class="choiceItemDrinkName" id="choiceItemDrinkName{{ $drink->id }}">{{ $drink->name }}</span>
                                                <br>
                                                <span class="choiceItemPrice">${{ $price }}</span>
                                                <br>

                                            <?php
                                                }
                                            ?>

                                            <div class="quantityDiv mx-auto">
                                                <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus{{ $drink->id }}"><i class="fas fa-minus"></i></button>
                                                <input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity{{ $drink->id }}" disabled>
                                                <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus{{ $drink->id }}"><i class="fas fa-plus"></i></button>
                                            </div>
                                            <div>
                                                <button type="button" class="btn bg-light border addToCartForDrinkOnly" id="addToCartForDrinkOnly{{ $drink->id }}" disabled>Add to Cart</button>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                        <?php
                                } else {
                                    $tableName = $drink->tablename;
                        ?>            
                                    <div class="col-md-4 text-center">
                                        <div class="choiceItemDrink" id="choiceItemDrink{{ $drink->id }}">
                                            <img src="\images\{{ $drink->gallery }}" style="width:60%">
                                            <br> 

                                            <span class="choiceItemDrinkName" id="choiceItemDrinkName{{ $drink->id }}">{{ $drink->name }}</span>
                                            <div style="padding-top:10px; font-size:20px;">
                                                <select name="selectDrink" class="selectDrink" id="selectDrink{{ $drink->id }}" style="height: 37px; padding: 0px 10px; ">
                                                    <option value=0 selected disable>Choose the flavor</option>
                                                    <?php
                                                        $drinkLists = DB::table($tableName)->get(); // this is for fountains and juices table
                                                        foreach ($drinkLists as $drinkList) {
                                                    ?>        
                                                            <option value={{ $drinkList->id }}>{{ $drinkList->name }}</option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div style="padding-top:10px; font-size:20px;">
                                                <select name="productDrinks" id="productDrinks{{ $drink->id }}" style="height: 37px; padding: 0px 10px; ">
                                                    @foreach ($productDrinks as $productDrink)
                                                        <option value={{ $productDrink->id }}>{{ $productDrink->name }} - ${{ $productDrink->price }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="quantityDiv mx-auto">
                                                <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus{{ $drink->id }}"><i class="fas fa-minus"></i></button>
                                                <input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity{{ $drink->id }}" disabled>
                                                <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus{{ $drink->id }}"><i class="fas fa-plus"></i></button>
                                            </div>
                                            <div>
                                                <button type="button" class="btn bg-light border addToCartForDrinkOnly" id="addToCartForDrinkOnly{{ $drink->id }}" disabled>Add to Cart</button>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                        <?php  
                                }
                            }    
                        ?>
                    </div>*/
    }

    protected function loadComboChoices($product)
    {
        $sides = DB::table('sides')->get();
        $chickenEntrees = DB::table('entrees')->where('category', 'Chicken')->get();
        $beefEntrees = DB::table('entrees')->where('category', 'Beef')->get();
        $shrimpEntrees = DB::table('entrees')->where('category', 'Shrimp')->get();
        $combo = DB::table('combos')->where('product_id', $product->id)->first();
        $sideQuantitySummary = "Choose " .$combo->side ." Side";
        $entreeQuantitySummary = "Choose " .$combo->entree ." Entree";
        if ($combo->side == 1) {
            $sideQuantitySummary .= " (or Half/Half)";
        } else {
            $sideQuantitySummary .= "s";
        }
        if ($combo->entree > 1) {
            $entreeQuantitySummary .= "s";
        }

        $html = "";
        $html .= "<h1>Choices for " .$product->name ."</h1>";
        $html .= "<div class=\"row\">";
        $html .=    "<div class=\"text-start\">";
        $html .=        "<br>";
        $html .=        "<h3>" .$sideQuantitySummary ."</h3>";
        $html .=        "<input type=\"hidden\" id=\"sideMaxQuantity\" value=\"" .$combo->side ."\"/>";
        $html .=        "<br>";
        $html .=    "</div>";
                    foreach($sides as $side) {
        $html .=        "<div class=\"col-md-4 text-center\">";
        $html .=            "<div class=\"choiceItemSide\" id=\"choiceItemSide" .$side->id ."\">";
        $html .=                "<img src=\"\\images\\" .$side->gallery ."\" style=\"width:60%\">";
        $html .=                "<br>";
        $html .=                "<span class=\"choiceItemSideName\" id=\"choiceItemSideName" .$side->id ."\">" .$side->name ."</span>";
        $html .=            "</div>";
        $html .=            "<div class=\"selectedDiv\">";
        $html .=                "<h3 class=\"sideSelected\" id=\"sideSelected" .$side->id ."\"></h3>";
        $html .=                "<div class=\"sideQuantityIncrementDiv mx-auto\" id=\"sideQuantityIncrementDiv" .$side->id ."\" style=\"display: none;\">";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle sideQuantityMinus\" id=\"sideQuantityMinus" .$side->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center sideQuantity\" value=\"0\" id=\"sideQuantity" .$side->id ."\" disabled>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle sideQuantityPlus\" id=\"sideQuantityPlus" .$side->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                "</div>";
        $html .=            "</div>";
        $html .=        "</div>";
                    }   
        $html .=    "<div class=\"text-start\">";
        $html .=        "<br>";
        $html .=        "<br>";
        $html .=        "<h3>" .$entreeQuantitySummary ."</h3>";
        $html .=        "<input type=\"hidden\" id=\"entreeMaxQuantity\" value=\"" .$combo->entree ."\"/>";
        $html .=        "<h5>Chicken</h5>";
        $html .=    "</div>";
                    foreach($chickenEntrees as $chickenEntree) {
        $html .=        "<div class=\"col-md-4 text-center\">";
        $html .=            "<div class=\"choiceItemEntree\" id=\"choiceItemEntree" .$chickenEntree->id ."\">";
        $html .=                "<img src=\"\\images\\" .$chickenEntree->gallery ."\" style=\"width:60%\">";
        $html .=                "<br>";
        $html .=                "<span class=\"choiceItemEntreeName\" id=\"choiceItemEntreeName" .$chickenEntree->id ."\">" .$chickenEntree->name ."</span>";  
        $html .=            "</div>";
        $html .=            "<div class=\"selectedDiv\">";
        $html .=                "<h3 class=\"entreeSelected\" id=\"entreeSelected" .$chickenEntree->id ."\"></h3>";
        $html .=                "<div class=\"entreeQuantityIncrementDiv mx-auto\" id=\"entreeQuantityIncrementDiv" .$chickenEntree->id ."\" style=\"display: none;\">";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityMinus\" id=\"entreeQuantityMinus" .$chickenEntree->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center entreeQuantity\" value=\"0\" id=\"entreeQuantity" .$chickenEntree->id ."\" disabled>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityPlus\" id=\"entreeQuantityPlus" .$chickenEntree->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                "</div>";
        $html .=            "</div>";
        $html .=            "<br>";
        $html .=        "</div>";
                    }
        $html .=    "<div class=\"text-start\">";
        $html .=        "<br>";
        $html .=        "<h5>Beef</h5>";
        $html .=    "</div>";
                    foreach($beefEntrees as $beefEntree) {
        $html .=        "<div class=\"col-md-4 text-center\">";
        $html .=            "<div class=\"choiceItemEntree\" id=\"choiceItemEntree" .$beefEntree->id ."\">";
        $html .=                "<img src=\"\\images\\" .$beefEntree->gallery ."\" style=\"width:60%\">";
        $html .=                "<br>";
        $html .=                "<span class=\"choiceItemEntreeName\" id=\"choiceItemEntreeName" .$beefEntree->id ."\">" .$beefEntree->name ."</span>";  
        $html .=            "</div>";
        $html .=            "<div class=\"selectedDiv\">";
        $html .=                "<h3 class=\"entreeSelected\" id=\"entreeSelected" .$beefEntree->id ."\"></h3>";
        $html .=                "<div class=\"entreeQuantityIncrementDiv mx-auto\" id=\"entreeQuantityIncrementDiv" .$beefEntree->id ."\" style=\"display: none;\">";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityMinus\" id=\"entreeQuantityMinus" .$beefEntree->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center entreeQuantity\" value=\"0\" id=\"entreeQuantity" .$beefEntree->id ."\" disabled>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityPlus\" id=\"entreeQuantityPlus" .$beefEntree->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                "</div>";
        $html .=            "</div>";
        $html .=            "<br>";
        $html .=        "</div>";
                    }
        $html .=    "<div class=\"text-start\">";
        $html .=        "<br>";
        $html .=        "<h5>Shrimp</h5>";
        $html .=    "</div>";
                    foreach($shrimpEntrees as $shrimpEntree) {
        $html .=        "<div class=\"col-md-4 text-center\">";
        $html .=            "<div class=\"choiceItemEntree\" id=\"choiceItemEntree" .$shrimpEntree->id ."\">";
        $html .=                "<img src=\"\\images\\" .$shrimpEntree->gallery ."\" style=\"width:60%\">";
        $html .=                "<br>";
        $html .=                "<span class=\"choiceItemEntreeName\" id=\"choiceItemEntreeName" .$shrimpEntree->id ."\">" .$shrimpEntree->name ."</span>";  
        $html .=            "</div>";
        $html .=            "<div class=\"selectedDiv\">";
        $html .=                "<h3 class=\"entreeSelected\" id=\"entreeSelected" .$shrimpEntree->id ."\"></h3>";
        $html .=                "<div class=\"entreeQuantityIncrementDiv mx-auto\" id=\"entreeQuantityIncrementDiv" .$shrimpEntree->id ."\" style=\"display: none;\">";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityMinus\" id=\"entreeQuantityMinus" .$shrimpEntree->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center entreeQuantity\" value=\"0\" id=\"entreeQuantity" .$shrimpEntree->id ."\" disabled>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityPlus\" id=\"entreeQuantityPlus" .$shrimpEntree->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                "</div>";
        $html .=            "</div>";
        $html .=            "<br>";
        $html .=        "</div>";
                    }

        // For Kid's Meal drink
        if ($combo->drink > 0) {
            //$productFountain = DB::table('products')->where('id', 29)->first();
            //$productWater = DB::table('products')->where('id', 5)->first();
            //$fountains = DB::table('fountains')->get();
            $drinkQuantitySummary = "Choose " .$combo->drink ." Drink (Default: Small Fountain Drink)";
            $comboDrinks = DB::table('combodrinks')->get();

            $html .=    "<div class=\"text-start\">";
            $html .=        "<br>";
            $html .=        "<h3>" .$drinkQuantitySummary ."</h3>";
            $html .=        "<input type=\"hidden\" id=\"drinkMaxQuantity\" value=\"" .$combo->drink ."\"/>";
            $html .=        "<br>";
            $html .=    "</div>";
                        foreach($comboDrinks as $comboDrink) {
                            if ($comboDrink->tablename != "") {
                                $tableNameForSelect = $comboDrink->tablename;
                                $listItems = DB::table($tableNameForSelect)->get(); 
            $html .=            "<div class=\"col-md-4 text-center\">";
            $html .=                "<div class=\"choiceItemDrinkWithSelect\" id=\"choiceItemDrinkWithSelect" .$comboDrink->id ."\">";
            $html .=                    "<img src=\"\\images\\" .$comboDrink->gallery ."\" style=\"width:60%\">";                          
            $html .=                    "<div style=\"padding-top:10px; font-size:20px;\">";
            $html .=                        "<span class=\"choiceItemDrinkName\" id=\"choiceItemDrinkName" .$comboDrink->id ."\">" .$comboDrink->name ."</span>";
            $html .=                        "<select name=\"comboDrink\" class=\"comboDrink\" id=\"comboDrink" .$comboDrink->id ."\" style=\"height: 37px; padding: 4px 10px; margin: 0px 10px\">";
            $html .=                            "<option value = \"0\" selected disable>Choose the flavor</option>";
                                                foreach ($listItems as $listItem) {
            $html .=                                "<option value=" .$listItem->id .">" .$listItem->name ."</option>";
                                                }
            $html .=                        "</select>";
            $html .=                    "</div>"; 
            $html .=                "</div>";
            $html .=                "<div class=\"selectedDiv\">";
            $html .=                    "<h3 class=\"drinkSelected\" id=\"drinkSelected" .$comboDrink->id ."\"></h3>";
            $html .=                "</div>";
            $html .=            "</div>";
                            } else {
            $html .=            "<div class=\"col-md-4 text-center\">";
            $html .=                "<div class=\"choiceItemDrink\" id=\"choiceItemDrink" .$comboDrink->id ."\">";
            $html .=                    "<img src=\"\\images\\" .$comboDrink->gallery ."\" style=\"width:60%\">";
            $html .=                    "<br>";
                                        $displayExtraCharge = ($comboDrink->price > 0) ? (" - Extra Charge: $" .$comboDrink->price) : "";                                        
            $html .=                    "<span class=\"choiceItemDrinkName\" id=\"choiceItemDrinkName" .$comboDrink->id ."\">" .$comboDrink->name .$displayExtraCharge ."</span>";
            $html .=                "</div>";
            $html .=                "<div class=\"selectedDiv\">";
            $html .=                    "<h3 class=\"drinkSelected\" id=\"drinkSelected" .$comboDrink->id ."\"></h3>";
            $html .=                "</div>";
            $html .=            "</div>";
                            }
                        }
        }

        $html .=    "<div class=\"col-md-4 my-auto\">";
        $html .=        "<div class=\"quantityDiv mx-auto\">";
        $html .=            "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$product->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=            "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"1\" id=\"quantity" .$product->id ."\" disabled style=\"margin: 0px 10px\">";
        $html .=            "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$product->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=        "</div>";
        $html .=        "<div>";
        $html .=            "<br>";
        $html .=            "<button type=\"button\" class=\"btn bg-light border addToCartForCombo\" disabled id=\"addToCartForCombo" .$product->id ."\">Add to Cart</button>";
        $html .=        "</div>";
        $html .=    "</div>";
        $html .= "</div>";

        return $html;

                    /*<div class="row">
                        <div class="text-start">
                            <br>
                            <h3>Choose One Side (or Half/Half)</h3>
                            <br>
                        </div>
                        @foreach($sides as $side)
                            <div class="col-md-4 text-center">
                                <div class="choiceItemSide" id="choiceItemSide{{ $side->id }}">
                                    <img src="\images\{{ $side->gallery }}" style="width:60%">
                                    <br>
                                    <span class="choiceItemSideName" id="choiceItemSideName{{ $side->id }}">{{ $side->name }}</span>
                                </div>
                                <div class="selectedDiv">
                                    <h3 class="sideSelected" id="sideSelected{{ $side->id }}"></h3>
                                    <div class="sideQuantityIncrementDiv mx-auto" id="sideQuantityIncrementDiv{{ $side->id }}" style="display: none;">
                                        <button type="button" class="btn bg-light border rounded-circle sideQuantityMinus" id="sideQuantityMinus{{ $side->id }}"><i class="fas fa-minus"></i></button>
                                        <input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="1" id="sideQuantity{{ $side->id }}" disabled>
                                        <button type="button" class="btn bg-light border rounded-circle sideQuantityPlus" id="sideQuantityPlus{{ $side->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endforeach

                        <div class="text-start">
                            <br>
                            <br>
                            <h3>Choose One Entree</h3>
                            <h5>Chicken</h5>
                        </div>
                        @foreach($chickenEntrees as $chickenEntree)
                            <div class="col-md-4 text-center">
                                <div class="choiceItemEntree" id="choiceItemEntree{{ $chickenEntree->id }}">
                                    <img src="\images\{{ $chickenEntree->gallery }}" style="width:60%">
                                    <br>
                                    <span class="choiceItemEntreeName" id="choiceItemEntreeName{{ $chickenEntree->id }}">{{ $chickenEntree->name }}</span>  
                                </div>
                                <div class="selectedDiv">
                                    <h3 class="entreeSelected" id="entreeSelected{{ $chickenEntree->id }}"></h3>
                                    <div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv{{ $chickenEntree->id }}" style="display: none;">
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus{{ $chickenEntree->id }}"><i class="fas fa-minus"></i></button>
                                        <input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity{{ $chickenEntree->id }}" disabled>
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus{{ $chickenEntree->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endforeach

                        <div class="text-start">
                            <br>
                            <h5>Beef</h5>
                        </div>
                        @foreach($beefEntrees as $beefEntree)
                            <div class="col-md-4 text-center">
                                <div class="choiceItemEntree" id="choiceItemEntree{{ $beefEntree->id }}">
                                    <img src="\images\{{ $beefEntree->gallery }}" style="width:60%">
                                    <br>
                                    <span class="choiceItemEntreeName" id="choiceItemEntreeName{{ $beefEntree->id }}">{{ $beefEntree->name }}</span>  
                                </div>
                                <div class="selectedDiv">
                                    <h3 class="entreeSelected" id="entreeSelected{{ $beefEntree->id }}"></h3>
                                    <div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv{{ $beefEntree->id }}" style="display: none;">
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus{{ $beefEntree->id }}"><i class="fas fa-minus"></i></button>
                                        <input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity{{ $beefEntree->id }}" disabled>
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus{{ $beefEntree->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endforeach

                        <div class="text-start">
                            <br>
                            <h5>Shrimp</h5>
                        </div>
                        @foreach($shrimpEntrees as $shrimpEntree)
                            <div class="col-md-4 text-center">
                                <div class="choiceItemEntree" id="choiceItemEntree{{ $shrimpEntree->id }}">
                                    <img src="\images\{{ $shrimpEntree->gallery }}" style="width:60%">
                                    <br>
                                    <span class="choiceItemEntreeName" id="choiceItemEntreeName{{ $shrimpEntree->id }}">{{ $shrimpEntree->name }}</span>  
                                </div>
                                <div class="selectedDiv">
                                    <h3 class="entreeSelected" id="entreeSelected{{ $shrimpEntree->id }}"></h3>
                                    <div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv{{ $shrimpEntree->id }}" style="display: none;">
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus{{ $shrimpEntree->id }}"><i class="fas fa-minus"></i></button>
                                        <input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity{{ $shrimpEntree->id }}" disabled>
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus{{ $shrimpEntree->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endforeach

                        <div class="col-md-4 my-auto">
                            <div class="quantityDiv mx-auto">
                                <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus{{ $product->id }}"><i class="fas fa-minus"></i></button>
                                <input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity{{ $product->id }}" disabled>
                                <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus{{ $product->id }}"><i class="fas fa-plus"></i></button>
                            </div>
                            <div>
                                <br>
                                <button type="button" class="btn bg-light border addToCartForCombo" id="addToCartForCombo{{ $product1->id }}">Add to Cart</button>
                            </div>
                        </div>
                    </div>*/

                    // Kid's Meal small drink
                    /*<h1>Choices for {{ $product->name }} </h1>
                    <div class="text-start">
                        <br>
                        <h3>Choose Flavour of Small Drink</h3>
                        <br>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="choiceItemDrink" id="choiceItemDrink{{ $productFountain->id }}">
                            <img src="\images\{{ $productFountain->gallery }}" style="width:60%">
                            <div style="padding-top:10px; font-size:25px;">
                                <select name="fountains" id="fountains">
                                    @foreach ($fountains as $fountain)
                                        <option value={{ $fountain->id }}>{{ $fountain->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>*/

                    // Old Menu above
                    /*@foreach($products as $product)
                        <div class="eachMenu" id="eachMenu{{ $product->id }}p">
                            <div class="menuItem" id="menuItem{{ $product->id }}p">
                                <span class="menuItemName{{ $product->id }}p">{{ $product->name }}</span>
                                <br>
                                <span class="menuItemPrice">${{ $product->price }}</span>
                                <br>
                                <span class="menuItemDescription">{{ $product->description }}</span>            
                            </div>      
                        </div>
                        <br>
                    @endforeach
                    @foreach($menus as $menu)
                        <div class="eachMenu" id="eachMenu{{ $menu->id }}">
                            <div class="menuItem" id="menuItem{{ $menu->id }}">
                                <span class="menuItemName{{ $menu->id }}">{{ $menu->name }}</span>
                                <br>
                                <span class="menuItemDescription">{{ $menu->description }}</span>            
                            </div>      
                        </div>
                        <br>
                    @endforeach*/	
    }

    protected function loadIndividualSideChoices($single, $mainMenuId)
    {
        $sides = DB::table('sides')->get();
        $productSides = DB::table('products')->where('menu_id', $mainMenuId)->where('category', 'Side')->get();

        $html = "";
        $html .= "<h1>Choices for " .$single->name ."</h1>";
        $html .= "<div class=\"row\">";    
                    foreach($sides as $side) {
        $html .=        "<div class=\"col-md-4 text-center\">";
        $html .=            "<div class=\"choiceItemSide\" id=\"choiceItemSide" .$side->id ."\">";
        $html .=                "<img src=\"\\images\\" .$side->gallery ."\" style=\"width:60%\">";
        $html .=                "<br>";
        $html .=                "<span class=\"choiceItemSideName\" id=\"choiceItemSideName" .$side->id ."\">" .$side->name ."</span>";
        $html .=                "<div>";
        $html .=                    "<select name=\"productSides\" id=\"productSides" .$side->id ."\" style=\"padding:5px 10px; font-size:18px;\">";
                                        foreach ($productSides as $productSide) {
        $html .=                            "<option value=" .$productSide->id .">" .$productSide->name ." - $" .$productSide->price ."</option>";
                                        }    
        $html .=                    "</select>";
        $html .=                "</div>";
        $html .=                "<div class=\"quantityDiv mx-auto\">";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$side->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"0\" id=\"quantity" .$side->id ."\" disabled>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$side->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                "</div>";
        $html .=                "<div>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border addToCartForSide\" id=\"addToCartForSide" .$side->id ."\" disabled>Add to Cart</button>";
        $html .=                "</div>";
        $html .=            "</div>";
        $html .=            "<br>";
        $html .=        "</div>";
                    }
        $html .= "</div>";

        return $html;

                    /*<div class="row">    
                        @foreach($sides as $side)
                            <div class="col-md-4 text-center">
                                <div class="choiceItemSide" id="choiceItemSide{{ $side->id }}">
                                    <img src="\images\{{ $side->gallery }}" style="width:60%">
                                    <br>
                                    <span class="choiceItemSideName" id="choiceItemSideName{{ $side->id }}">{{ $side->name }}</span>
                                    <div>
                                        <select name="productSides" id="productSides{{ $side->id }}" style="padding:5px 10px; font-size:18px;">
                                            @foreach ($productSides as $productSide)
                                                <option value={{ $productSide->id }}>{{ $productSide->name }} - ${{ $productSide->price }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="quantityDiv mx-auto">
                                        <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus{{ $side->id }}"><i class="fas fa-minus"></i></button>
                                        <input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity{{ $side->id }}" disabled>
                                        <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus{{ $side->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn bg-light border addToCartForSingle" id="addToCartForSingle{{ $side->id }}" disabled>Add to Cart</button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endforeach
                    </div>*/
    }

    protected function loadIndividualEntreeChoices($single, $mainMenuId, $category)
    {
        $entrees = DB::table('entrees')->where('category', $category)->get();
        $productEntrees = DB::table('products')->where('menu_id', $mainMenuId)->where('category', $category)->get();

        $html = "";
        $html .= "<h1>Choices for " .$single->name ."</h1>";
        $html .= "<div class=\"row\">";    
                    foreach($entrees as $entree) {
        $html .=        "<div class=\"col-md-4 text-center\">";
        $html .=            "<div class=\"choiceItemEntree\" id=\"choiceItemEntree" .$entree->id ."\">";
        $html .=                "<img src=\"\\images\\" .$entree->gallery ."\" style=\"width:60%\">";
        $html .=                "<br>";
        $html .=                "<span class=\"choiceItemEntreeName\" id=\"choiceItemEntreeName" .$entree->id ."\">" .$entree->name ."</span>";
        $html .=                "<div>";
        $html .=                    "<select name=\"productEntrees\" id=\"productEntrees" .$entree->id ."\" style=\"padding:5px 10px; font-size:18px;\">";
                                        foreach ($productEntrees as $productEntree) {
        $html .=                            "<option value=" .$productEntree->id .">" .$productEntree->name ." - $" .$productEntree->price ."</option>";
                                        }    
        $html .=                    "</select>";
        $html .=                "</div>";
        $html .=                "<div class=\"quantityDiv mx-auto\">";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$entree->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"0\" id=\"quantity" .$entree->id ."\" disabled>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$entree->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                "</div>";
        $html .=                "<div>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border addToCartForEntree\" id=\"addToCartForEntree" .$entree->id ."\" disabled>Add to Cart</button>";
        $html .=                "</div>";
        $html .=            "</div>";
        $html .=            "<br>";
        $html .=        "</div>";
                    }
        $html .= "</div>";

        return $html;
    }
}
