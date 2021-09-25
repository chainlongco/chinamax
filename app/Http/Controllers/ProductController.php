<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
require_once(public_path() ."/shared/component.php");

class ProductController extends Controller
{
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

    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%' .$request->search .'%')->orWhere('description', 'like', '%' .$request->search .'%' )->get();
        return view('search', ['products'=>$products]);
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

    public function cartData(Request $request)
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
    }





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
        echo (priceDetaiDivElement());
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
