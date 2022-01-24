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

    /*public function editWithSerialNumber(Request $request) {
        $menus = DB::table('menus')->where('level', 0)->get();
        
        // For Combo
        $menuCombo = DB::table('menus')->where('name', 'Combo')->first();
        $products = DB::table('products')->where('menu_id', $menuCombo->id)->get();
        $comboArray = array('menu'=>$menuCombo, 'products'=>$products);

        // For Individual Side/Entree
        $menuIndividual = DB::table('menus')->where('name', 'Individual Side/Entree')->first();
        $singles = DB::table('singles')->get();
        $singleArray = array('menu'=>$menuIndividual, 'singles'=>$singles);

        //return view('order', compact('menus', 'comboArray', 'singleArray'));

        $serialNumber = $request->serialNumber;
        return view('order', compact('menus', 'comboArray', 'singleArray', 'serialNumber'));
    }*/

    public function editWithSerialNumber($serialNumber) {
        $menus = DB::table('menus')->where('level', 0)->get();
        
        // For Combo
        $menuCombo = DB::table('menus')->where('name', 'Combo')->first();
        $products = DB::table('products')->where('menu_id', $menuCombo->id)->get();
        $comboArray = array('menu'=>$menuCombo, 'products'=>$products);

        // For Individual Side/Entree
        $menuIndividual = DB::table('menus')->where('name', 'Individual Side/Entree')->first();
        $singles = DB::table('singles')->get();
        $singleArray = array('menu'=>$menuIndividual, 'singles'=>$singles);

        //return view('order', compact('menus', 'comboArray', 'singleArray'));

        return view('order', compact('menus', 'comboArray', 'singleArray', 'serialNumber'));
    }

    public function orderEdit(Request $request) {
        $serialNumber = $request->serialNumber;
        $cart = new Cart(Session::get('cart'));
        $items = $cart->items;
        $item = $items[$serialNumber];
        $product = $item['item'];
        $quantity = $item['quantity'];
        $subItems = $item['subItems'];
        $totalPricePerItem = $item['totalPricePerItem'];
        if ($product->menu_id == 1) {   // Appetizers
            return response()->json(['serialNumber'=>$serialNumber, 'product'=>$product, 'quantity'=>$quantity]);
        } else if ($product->menu_id == 2) {    // Drinks
            $drink = DB::table('drinks')->where('name', $product->category)->first();
            if ($drink->tablename == "") {  // Water and Bottle Water
                return response()->json(['serialNumber'=>$serialNumber, 'product'=>$product, 'quantity'=>$quantity, 'drink'=>$drink]);
            } else {
                $sizeProducts = DB::table('products')->where('category', $product->category)->get();
                $keys = array_keys($subItems);
                foreach ($keys as $key) {
                    $category = $subItems[$key]['category'];
                    if ($category == "DrinkOnly") {
                        if (array_key_exists('selectDrink', $subItems[$key])) {
                             $selectDrink = $subItems[$key]['selectDrink'];
                        }
                    }
                }
                $selectDrinks = DB::table($drink->tablename)->get();
                if ($sizeProducts->count() == 1) {   
                    return response()->json(['serialNumber'=>$serialNumber, 'product'=>$product, 'quantity'=>$quantity, 'drink'=>$drink, 'selectDrinks'=>$selectDrinks, 'selectDrink'=>$selectDrink, 'sizeProducts'=>$sizeProducts]);
                } else {    // Greater than 1 -- need Select Box for Fountain Drink and Fresh Juice -- size
                    return response()->json(['serialNumber'=>$serialNumber, 'product'=>$product, 'quantity'=>$quantity, 'drink'=>$drink, 'selectDrinks'=>$selectDrinks, 'selectDrink'=>$selectDrink, 'sizeProducts'=>$sizeProducts]);
                }             
            }
        } else if ($product->menu_id == 4) {    // Individual Side/Entree
            if ($product->category == "Side") {
                $productSides = DB::table('products')->where('category', "Side")->get();
                $keys = array_keys($subItems);
                foreach ($keys as $key) {
                    $category = $subItems[$key]['category'];
                    if ($category == "Side") {
                        $side = $subItems[$key]['item'];
                    }
                }
                return response()->json(['serialNumber'=>$serialNumber, 'product'=>$product, 'quantity'=>$quantity, 'productSidesOrEntrees'=>$productSides, 'sideOrEntree'=>$side]);
            } else if ($product->category == "Chicken" || $product->category == "Beef" || $product->category == "Shrimp") {
                if ($product->category == "Chicken") {
                    $productEntrees = DB::table('products')->where('category', "Chicken")->get();
                } else if ($product->category == "Beef") {
                    $productEntrees = DB::table('products')->where('category', "Beef")->get();
                } else if ($product->category == "Shrimp") {
                    $productEntrees = DB::table('products')->where('category', "Shrimp")->get();
                }
                $keys = array_keys($subItems);
                foreach ($keys as $key) {
                    $category = $subItems[$key]['category'];
                    if ($category == "Entree") {
                        $entree = $subItems[$key]['item'];
                    }
                }
                return response()->json(['serialNumber'=>$serialNumber, 'product'=>$product, 'quantity'=>$quantity, 'productSidesOrEntrees'=>$productEntrees, 'sideOrEntree'=>$entree]);
            }
        } else if ($product->menu_id == 3) {    // Combo
            $sides = DB::table('sides')->get();
            $chickenEntrees = DB::table('entrees')->where('category', 'Chicken')->get();
            $beefEntrees = DB::table('entrees')->where('category', 'Beef')->get();
            $shrimpEntrees = DB::table('entrees')->where('category', 'Shrimp')->get();
            $combo = DB::table('combos')->where('product_id', $product->id)->first();
            $comboDrinks = DB::table('combodrinks')->get();
            $fountains = DB::table('fountains')->get();
            return response()->json(['serialNumber'=>$serialNumber, 'product'=>$product, 'quantity'=>$quantity, 'sides'=>$sides, 'chickenEntrees'=>$chickenEntrees, 'beefEntrees'=>$beefEntrees, 'shrimpEntrees'=>$shrimpEntrees, 'combo'=>$combo, 'comboDrinks'=>$comboDrinks, 'fountains'=>$fountains, 'subItems'=>$subItems]);
        } else {
            return response()->json(['serialNumber'=>$serialNumber, 'product'=>$product, 'quantity'=>$quantity, 'subItems'=>$subItems, 'totalPricePerItem'=>$totalPricePerItem]);
        }
    }

    public function orderUpdated(Request $request)
    {
        $serialNumber = $request->serialNumber;
        $quantity = $request->quantity;
        $productId = $request->productId;
        $subItems = json_decode($request->subItems, true);
        $oldCart = Session::get('cart');
        $newCart = new Cart($oldCart);
        $newCart->updateItem($serialNumber, $productId, $quantity, $subItems);
        Session::put('cart', $newCart);
        $priceDetail = retrievePriceDetail();
        $items = $newCart->items;   //$storedItem = ['item'=>$item, 'subItem'=>$subItem, 'quantity'=>$quantity];
        return response()->json(['priceDetail'=>$priceDetail, 'items'=>$items]);
    }

    public function cartNote(Request $request) {
        $oldCart = null;
        if (Session::has('cart')) {
            $oldCart = Session::get('cart');
        }
        $newCart = new Cart($oldCart);
        $newCart->addNote($request->note);
        Session::put('cart', $newCart);
        return response()->json(['note'=>$newCart->note]);
    }

    public function emptyCart() {
        Session::forget('cart');
        $priceDetail = retrievePriceDetail();
        $items = [];
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
