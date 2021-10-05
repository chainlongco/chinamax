<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function menu() {
        $menus = DB::table('menus')->where('level', 0)->get();
        $level1s = DB::table('menus')->select('id')->where('level', 1)->get();
        $ids = array();
        foreach ($level1s as $level) {
            array_push($ids, $level->id);
        }
        $products = DB::table('products')->whereIn('menu_id', $ids)->get();
        return view('order', compact('menus', 'products'));
    }
}
