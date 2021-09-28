<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function menu() {
        $menus = DB::table('menus')->get();
        return view('order', compact('menus'));
    }
}
