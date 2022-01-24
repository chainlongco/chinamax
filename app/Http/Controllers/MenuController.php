<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

require_once(public_path() ."/shared/component.php");

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
            echo loadAppetizesChoices($menu);
        } else if ($menuName === "Small Platter") { // For Combo
            echo loadComboChoices($product);
        } else if ($menuName === "Regular Platter") {   // For Combo
            echo loadComboChoices($product);
        } else if ($menuName === "Large Platter") { // For Combo
            echo loadComboChoices($product);
        } else if ($menuName === "Party Tray") {    // For Combo
            echo loadComboChoices($product);
        } else if ($menuName === "Kid's Meal") {    // For Combo
            echo loadComboChoices($product);
        } else if ($menuName === "Side"){   // For Individual Side/Entree
            echo loadIndividualSideChoices($single, $mainMenuId);
        } else if ($menuName === "Chicken Entree"){   // For Individual Side/Entree
            echo loadIndividualEntreeChoices($single, $mainMenuId, "Chicken");
        } else if ($menuName === "Beef Entree"){   // For Individual Side/Entree
            echo loadIndividualEntreeChoices($single, $mainMenuId, "Beef");
        } else if ($menuName === "Shrimp Entree"){   // For Individual Side/Entree
            echo loadIndividualEntreeChoices($single, $mainMenuId, "Shrimp");
        } else if ($menuName === "Drinks") {  //For Drink
            echo loadDrinksChoices($menuName);
        }
    }

}
