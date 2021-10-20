<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function menu() {
        $menus = DB::table('menus')->where('level', 0)->get();
        $level1s = DB::table('menus')->where('level', 1)->get();
        $level1Arrays = array();
        foreach ($level1s as $level) {
            //array_push($ids, $level->id);
            $products = DB::table('products')->where('menu_id', $level->id)->get();
            //array_push(level1Arrays, ['menu'=>$level, 'products'=>$products]);
            $level1Arrays[$level->id] = ['menu'=>$level, 'products'=>$products];
        }
        //$products = DB::table('products')->whereIn('menu_id', $ids)->get();
        return view('order', compact('menus', 'level1Arrays'));

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
}
