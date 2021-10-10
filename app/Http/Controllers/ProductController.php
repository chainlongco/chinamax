<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Shared\Cart;

require_once(public_path() ."/shared/component.php");

class ProductController extends Controller
{
    public function orderChoices(Request $request)
    {   // ToDo -- Needs to rewrite.......
        $menuId = $request->menuId;
        $menuName = "";
        if (!str_contains($menuId, 'p')) {   // from Menus table -- for Appetizer, Drink, Individual Side/Entree
            $menu = DB::table('menus')->where('id', $menuId)->first();
            $menuName = $menu->name;
        } else {    // From Products table -- Small Platter, Regular Platter, Large Platter, Kid's Meal, Party Tray
            $productId = substr($menuId, 0, (strlen($menuId) -1));
            $product = DB::table('products')->where('id', $productId)->first();
            $menuName = $product->name;
        }
        if ($menuName === "Appetizers") {
            echo loadAppetizesChoices($menuName);
        } else if ($menuName === "Drinks") {
            echo loadDrinksChoices($menuName);
        } else if ($menuName === "Individual Side/Entree"){
            echo loadIndividualSideEntreeChoices($menuName);
        } else if ($menuName === "Small Platter") {
            echo loadSmallPlatterChoices($product);
        } else if ($menuName === "Regular Platter") {
            echo loadRegularPlatterChoices($menuName);
        } else if ($menuName === "Large Platter") {
            echo loadLargePlatterChoices($menuName);
        } else if ($menuName === "Party Tray") {
            echo loadPartyTrayChoices($menuName);
        } else if ($menuName === "Kid's Meal") {
            echo loadKidsMealChoices($menuName);
        }
    }

    public function orderAdded(Request $request)
    {
        $productId = $request->productId;
        $quantity = $request->quantity;
        $subItem = $request->subItem;
        $product = DB::table('products')->where('id', $productId)->first();
        $oldCart = null;
        $count = 0;
        if (Session::has('cart')) {
            $oldCart = Session::get('cart');      
        }
        $newCart = new Cart($oldCart);
        $newCart->addNewItem($product, $quantity, $subItem);
        Session::put('cart', $newCart);
        $count = $newCart->totalQuantity;
        echo "<span id=\"cart_count\" class=\"text-warning bg-light\">" .$count ."</span>";
    }

    public function cartQuantityUpdated(Request $request)
    {
        $serialNumber = $request->serialNumber;
        $quantity = $request->quantity;
        $oldCart = Session::get('cart');
        $newCart = new Cart($oldCart);
        $newCart->updateItemQuantity($serialNumber, $quantity);
        Session::put('cart', $newCart);
        $priceDetail = retrievePriceDetail();
        $items = $newCart->items;   //$storedItem = ['item'=>$item, 'subItem'=>$subItem, 'quantity'=>$quantity];
        return response()->json(['priceDetail'=>$priceDetail, 'items'=>$items]);
    }

















    public function index()
    {
        /*if (Session::has('user')){
            print_r(Session::get('user'));
        } else {
            print_r("not set");
        }*/
        $products = Product::all();
        return view('product', ['products'=>$products]);
    }

    public function detail($id)
    {
        $product = Product::find($id);
        return view('detail', ['product'=>$product]);
    }

    public function addToCart($id)
    {
        if (!Session::has('cart'))
        {
            $item_array = array('productId'=>$id, 'quantity'=>'1');
            $cartArray = array();
            $cartArray[0] = $item_array;
            Session::put('cart', $cartArray);
        }
        else
        {
            $productIdExists = false;
            $productsArray = Session::get('cart');
            foreach(Session::get('cart') as $products) {
                $quantity = 0;
                foreach($products as $key=>$value) {
                    if ($key == 'productId' && $value == $id) {
                        $productIdExists = true;
                    }
                }
                if ($productIdExists == true) {
                    break;
                }
            }
            if ($productIdExists == false) {
                Session::push('cart', array('productId'=>$id, 'quantity'=>'1'));
            } else {
                foreach($productsArray as $key=>$value){
                    if($productsArray[$key]['productId'] == $id) {
                        Session::pull('cart.' .$key);
                        Session::push('cart', array('productId'=>$id, 'quantity'=>(int)$productsArray[$key]['quantity'] + 1));
                    } else {
                        //print_r("not inside");
                    }
                }
            }
        }
        return redirect('/cart');
    }

    public function cart()
    {
        return view('cart');
    }

    /*public function cartData(Request $request)
    {
        updateSessionData($request);
        
        $idArray = retrieveIdListFromSession();
        $products = Product::wherein('id', $idArray)->get();
        $productArray = array();
        $priceArray = array();

        $items = 0;
        $tax = 0;
        $subtotal = 0;
        $total = 0;
        $taxRate = 0.0825;

        foreach($products as $product) {
            $quantity = 0;
            $note = "";
            $data = Session::get('cart');
            foreach($data as $key=>$value) {             
                if ($data[$key]['productId'] == ($product->id)) {
                    $quantity = $data[$key]['quantity'];
                    break;
                }       
            }
            $array = array(
                'id'=>$product->id,
                'name'=>$product->name,
                'price'=>$product->price,
                'category'=>$product->category,
                'description'=>$product->description,
                'gallery'=>$product->gallery,
                'quantity'=>$quantity,
                'note'=>$note,
            );

            $items += $quantity;
            $subtotal += (floatval($product->price)) * $quantity;

            array_push($productArray, $array);
        }
        $tax = round(($subtotal * $taxRate), 2);
        $total = $subtotal + $tax;
        $priceArray = array('items'=>$items, 'subtotal'=>number_format($subtotal, 2, '.', ','), 'tax'=>number_format($tax, 2, '.', ','), 'total'=>number_format($total, 2, '.', ','));

        return response()->json([
            'products' => $productArray,
            'price' => $priceArray,
        ]);
    }*/





    public function cartPriceDetail(Request $request)
    {
        //print_r($request->input('quantity'));
        $id = $request->input('id');
        $quantity = $request->input('quantity');
        $productsArray = Session::get('cart');
        foreach($productsArray as $key=>$value){
            if($productsArray[$key]['productId'] == $id) {
                if ($quantity != 0) {
                    Session::pull('cart.' .$key);
                    Session::push('cart', array('productId'=>$id, 'quantity'=>(int)$quantity));
                } else {
                    Session::forget('cart.' .$key);
                }
            } else {
                //print_r("not inside");
            }
        }
        echo (priceDetailDivElement());
    }

    public function cartRemoveFromOrderList(Request $request)
    {
        //echo $request->input('id');
        $id = $request->input('id');
        $productsArray = Session::get('cart');
        foreach($productsArray as $key=>$value){
            if($productsArray[$key]['productId'] == $id) {
                Session::forget('cart.' .$key);
            } else {
                //print_r("not inside");
            }
        }
        echo orderListDivElement();
    }

    public function cartCount(Request $request)
    {

        $count = 0;
        if (Session::has('cart')) {
            foreach (Session::get('cart') as $products){
                foreach($products as $key=>$value) {
                    if ($key == "quantity") {
                        $count = $count + (int)$value;
                    }
                }
            }
        }
        echo cartCountSpanElement();
    }

}
