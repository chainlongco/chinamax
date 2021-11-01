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

    public function orderAdded(Request $request)
    {
        $productId = $request->productId;
        $quantity = $request->quantity;
        $subItems = json_decode($request->subItems, true);

        $combo = DB::table('combos')->where('product_id', $productId)->first();
        $pass = $this->validateSideAndEntreeAndDrink($productId, $subItems);
        if(!$pass) {
            return response()->json(['status'=>0, 'message'=>"Please select side and entree before you add order to cart."]);
        }
        
        $product = DB::table('products')->where('id', $productId)->first();
        $oldCart = null;
        $count = 0;
        if (Session::has('cart')) {
            $oldCart = Session::get('cart');      
        }
        $newCart = new Cart($oldCart);
        $newCart->addNewItem($product, $quantity, $subItems);
        Session::put('cart', $newCart);
        $count = $newCart->totalQuantity;
        echo "<span id=\"cart_count\" class=\"text-warning bg-light\">" .$count ."</span>";
    }

    protected function validateSideAndEntreeAndDrink($productId, $subItems)
    {
        $pass = true;
        $combo = DB::table('combos')->where('product_id', $productId)->first();
        if(!is_null($combo)) {
            $side = $combo->side;
            $entree = $combo->entree;
            $drink = $combo->drink;
            $quantityOfSubItems = $this->retrieveQuantityOfSubItems($subItems);
            if (($quantityOfSubItems['side'] == $side) && ($quantityOfSubItems['entree'] == $entree) && ($quantityOfSubItems['drink'] == $drink)) {
                $pass = true;
            } else {
                $pass = false;
            }
        }
        return $pass;
    }

    protected function retrieveQuantityOfSubItems($subItems)
    {
        $quantityOfSubItems = [];
        $side = 0;
        $entree = 0;
        $drink = 0;

        $keys = array_keys($subItems);
        foreach ($keys as $key) {         
            $category = $subItems[$key]['category'];
            $quantity = $subItems[$key]['quantity'];
            
            if ($category == "Side") {
                $side += $quantity;
            }
            if ($category == "Entree") {
                $entree += $quantity;
            }
            if ($category == "Drink") {
                $drink += $quantity;
            }
        }
        $quantityOfSubItems['side'] = $side;
        $quantityOfSubItems['entree'] = $entree;
        $quantityOfSubItems['drink'] = $drink;
        return $quantityOfSubItems;
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
