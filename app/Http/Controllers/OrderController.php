<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Shared\Cart;
use Validator;
use App\Shared\component;

//require_once(public_path() ."/shared/component.php");

class OrderController extends Controller
{
    public function cart()
    {
        return view('cart');
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

    public function validateSideAndEntreeAndDrink($productId, $subItems)
    {
        $pass = true;
        $combo = DB::table('combos')->where('product_id', $productId)->first();
        if(!is_null($combo)) {
            $side = $combo->side;
            $entree = $combo->entree;
            $drink = $combo->drink;
            $quantityOfSubItems = $this->retrieveQuantityOfSubItems($subItems);
            if (($quantityOfSubItems['Side'] == $side) && ($quantityOfSubItems['Entree'] == $entree) && ($quantityOfSubItems['Drink'] == $drink)) {
                $pass = true;
            } else {
                $pass = false;
            }
        }
        return $pass;
    }

    public function retrieveQuantityOfSubItems($subItems)
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
        $quantityOfSubItems['Side'] = $side;
        $quantityOfSubItems['Entree'] = $entree;
        $quantityOfSubItems['Drink'] = $drink;
        return $quantityOfSubItems;
    }

    public function listOrders() {
        $taxRate = 0.0825;
        $customers = DB::table('customers')->get();
        $orders = DB::table('orders')
                    ->select('orders.id', 'orders.customer_id', 'orders.quantity', 'orders.total', 'orders.note', 'orders.created_at', 'orders.updated_at', 'customers.first_name', 'customers.last_name', 'customers.phone', 'customers.email')
                    ->join('customers','customers.id','=','orders.customer_id')
                    ->get();
        
        $html = '';
        $html .=    '<table class="table table-striped table-hover cell-border" id="ordersDatatable" style="padding: 10px;">
                        <thead>
                            <tr style="border-top: 1px solid #000;">
                                <th class="text-center">First Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Tax</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Order Time</th>
                                <th class="text-center">Updated Time</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>';
        $html .=        '<tbody>';
                            if (!empty($orders)):
                                foreach($orders as $order):
                                    $phoneNumber = "";
                                    if( preg_match('/^(\d{3})(\d{3})(\d{4})$/', $order->phone,  $matches)) {
                                        $phoneNumber = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
                                    } else {
                                        $phoneNumber = $order->phone;
                                    }
                                    $tax = round(($order->total*$taxRate),2);
                                    $total = $order->total + $tax;

        $html .=        	        '<tr>';
        $html .=                        '<td class="align-middle" style="text-align: left;">' .$order->first_name .'</td>';
        $html .=                        '<td class="align-middle" style="text-align: left;">' .$order->last_name .'</td>';
        $html .=                        '<td class="align-middle" style="text-align: center;">' .$phoneNumber .'</td>';
        $html .=                        '<td class="align-middle" style="text-align: left;">' .$order->email .'</td>';
        $html .=                        '<td class="align-middle" style="text-align: right;">' .$order->quantity .'</td>';
        $html .=                        '<td class="align-middle" style="text-align: right;">$' .$order->total .'</td>';
        $html .=                        '<td class="align-middle" style="text-align: right;">$' .$tax  .'</td>';
        $html .=                        '<td class="align-middle" style="text-align: right;">$' .$total  .'</td>';
        $html .=                        '<td class="align-middle" style="text-align: center;">' .$order->created_at .'</td>';
        $html .=                        '<td class="align-middle" style="text-align: center;">' .$order->updated_at .'</td>';
        $html .=                        '<td>';
        $html .=                            '<div class="row justify-content-around" style="margin:auto;">';
        $html .=                                '<a href="order/edit/' .$order->id .'" class="col-md-5 btn btn-primary" title="Edit"><span class="bi-pencil-fill"></span></a>';
        $html .=                                '<a href="order/delete/' .$order->id .'" class="col-md-5 btn btn-danger" title="Delete" onclick="if(!confirm(' ."'Are you sure?'" .')){return false;}"><span class="bi-x-lg"></span></a>';
        $html .=                            '</div>';
        $html .=                        '</td>';
        $html .=                    '</tr>';
                                endforeach;
                            endif;

        $html .=     	'</tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Tax</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Order Time</th>
                                <th class="text-center">Updated Time</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </tfoot>';
        $html .=	'</table>';
        
        //scrollY: "530px", there is a bug for scrollY in DataTable: Header not align automatically when change window size. So, commented out
        $html .=    '<script>
                        $(document).ready(function(){
                            $("#ordersDatatable").DataTable({
                                //scrollY: "530px",
                                scrollCollapse: true,
                                "columnDefs": [{
                                    targets: [7],
                                    orderable: false
                                }]
                            });
                        });    
                    </script>';
        
        echo $html;
    }

    public function orderDelete($id) {
        $order = DB::table('orders')->where('id', $id);
        if ($order->delete()) {
            if (Session::has('cart')) {
                if (Session::get('cart')->orderId == $id) {
                    Session::forget('cart');
                }
            }
            return redirect('/order');
        }
        return redirect('/order');
    }

    public function orderEdit($id) {
        $this->loadOrderToSession($id);
        return view('cart');
    }

    protected function loadOrderToSession($orderId) {
        Session::forget('cart');
        $newCart = new Cart(null);

        $order = DB::table('orders')->where('id', $orderId)->first();
        if ($order) {
            $newCart->addNote($order->note);
            $newCart->addOrderIdAndCreatedDateTime($order->id, $order->created_at);
            $this->loginAsCustomer($order->customer_id);

            $order_products = DB::table('order_products')->where('order_id', $orderId)->get();
            foreach($order_products as $order_product) {
                $subItems = array();
                $product = DB::table('products')->where('id', $order_product->product_id)->first();
                if ($product->menu_id == 1) {   // Appetizers
                    // no subItems for Appetizers
                } else if ($product->menu_id == 2) {    // Drinks
                    $subItems = $this->retrieveSubItemsForDrinks($order_product->id, $product, $order_product->quantity);
                } else if ($product->menu_id == 4) {
                    $subItems = $this->retrieveSubItemsForSingle($order_product->id, $product, $order_product->quantity);
                } else if ($product->menu_id == 3) {
                    $subItems = $this->retrieveSubItemsForCombos($order_product->id);
                }
                $newCart->addNewItem($product, $order_product->quantity, $subItems);
            }
            Session::put('cart', $newCart);
        }        
    }

    protected function loginAsCustomer($customerId) {
        Session::forget('customer');
        $customer = DB::table('customers')->where('id', $customerId)->first();
        if ($customer) {
            Session::put('customer', $customer);
        }
    }

    protected function retrieveSubItemsForDrinks($orderProductId, $product, $quantity) {
        $subItems = [];
        $drinkArray = [];
        $drink = DB::table('drinks')->where('name', $product->category)->first();
        $orderDrink = DB::table('order_drinks')->where('order_product_id', $orderProductId)->first(); 
        $drinkArray = array("category"=>"DrinkOnly", "id"=>$drink->id, "quantity"=>$quantity, 'selectBoxId'=>$orderDrink->type_id);
        array_push($subItems, $drinkArray);
        return $subItems;
    }

    protected function retrieveSubItemsForSingle($orderProductId, $product, $quantity) {
        $subItems = [];
        if ($product->category == "Side") {
            $orderSide = DB::table('order_sides')->where('order_product_id', $orderProductId)->first();
            $sideArray = array("category"=>"Side", "id"=>$orderSide->side_id, "quantity"=>$quantity);
            array_push($subItems, $sideArray);
        } else {
            $orderEntree = DB::table('order_entrees')->where('order_product_id', $orderProductId)->first();
            $entree = DB::table('entrees')->where('id', $orderEntree->entree_id)->first();
            $entreeArray = array("category"=>"Entree","id"=>$orderEntree->entree_id, "quantity"=>$quantity);
            array_push($subItems, $entreeArray);
        }
        return $subItems;
    }

    protected function retrieveSubItemsForCombos($orderProductId) {
        $subItems = [];
        // For Side
        $orderSubSides = DB::table('order_sub_sides')->where('order_product_id', $orderProductId)->get();
        foreach ($orderSubSides as $orderSubSide) {
            $sideArray = array("category"=>"Side", "id"=>$orderSubSide->side_id, "quantity"=>$orderSubSide->quantity);
            array_push($subItems, $sideArray);
        }
        // For Entree
        $orderSubEntrees = DB::table('order_sub_entrees')->where('order_product_id', $orderProductId)->get();
        foreach ($orderSubEntrees as $orderSubEntree) {
            $entreeArray = array("category"=>"Entree", "id"=>$orderSubEntree->entree_id, "quantity"=>$orderSubEntree->quantity);
            array_push($subItems, $entreeArray);
        }
        // For Drink
        $orderSubDrinks = DB::table('order_sub_drinks')->where('order_product_id', $orderProductId)->get();
        foreach ($orderSubDrinks as $orderSubDrink) {
            if ($orderSubDrink->type_id != null) {
                $drinkArray = array("category"=>"Drink", "id"=>$orderSubDrink->drink_id, "quantity"=>$orderSubDrink->quantity, "selectBoxId"=>$orderSubDrink->type_id);
            } else {
                $drinkArray = array("category"=>"Drink", "id"=>$orderSubDrink->drink_id, "quantity"=>$orderSubDrink->quantity);
            }
            array_push($subItems, $drinkArray);
        }   
        return $subItems;
    }

    public function orderEditForPopup(Request $request) {
        $serialNumber = $request->serialNumber;
        $cart = new Cart(Session::get('cart'));
        $items = $cart->items;
        $item = $items[$serialNumber];
        $product = $item['productItem'];
        $quantity = $item['quantity'];
        $subItems = $item['subItems'];
        $totalPricePerProductItem = $item['totalPricePerProductItem'];
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
            return response()->json(['serialNumber'=>$serialNumber, 'product'=>$product, 'quantity'=>$quantity, 'subItems'=>$subItems, 'totalPricePerProductItem'=>$totalPricePerProductItem]);
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

    public function emptyCart() {
        Session::forget('cart');
        $priceDetail = retrievePriceDetail();
        $items = [];
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

    public function cartQuantityUpdated(Request $request)
    {
        $serialNumber = $request->serialNumber;
        $quantity = $request->quantity;
        $oldCart = Session::get('cart');
        $newCart = new Cart($oldCart);
        $newCart->updateItemQuantity($serialNumber, $quantity);
        Session::put('cart', $newCart);
        $priceDetail = retrievePriceDetail();
        $items = $newCart->items;   //$storedItem = ['productItem'=>$productItem, 'subItem'=>$subItem, 'quantity'=>$quantity];
        return response()->json(['priceDetail'=>$priceDetail, 'items'=>$items]);
    }

    public function checkout(Request $request) {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:254',
            'lastname' => 'required|max:254',
            'phone' => 'required',
            'email' => 'required|email',
            'zip'=> 'required',
            'card'=> 'required',
            'expired'=> 'required',
            'cvv'=> 'required'
        ]);
        if (!$validator->passes()) {
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }

        $exception = null;
        $cart = Session::get('cart');
        $orderId = $cart->orderId;
        // Save customer information
        // Save to orders table
        // Save to order_products table (Retrive summary field)
        // Save to order_sub_sides table
        // Save to order_sub_entrees table
        // Save to order_sub_drinks table
        // Save to order_drinks table
        // Save to order_sides table
        // Save to order_entrees table
        $exception = DB::transaction(function() use ($request, $cart) {
            try {
                $customerId = $this->retrieveCustomerId($request);
                if (Session::has('cart')){
                    $elements = "";
                    $items = array();
                    $totalQuantity = 0;
                    $totalPrice = 0;
                    $subItems = array();
                    $note = "";
                    $created = null;
                    $orderId = null;
                    foreach ($cart as $key=>$value) {
                        if ($key == 'totalQuantity') {
                            $totalQuantity = $value;
                        }
                        if ($key == 'totalPrice') {
                            $totalPrice = $value;
                        }
                        if ($key == 'items') {
                            $items = $value;
                        }
                        if ($key == 'note') {
                            $note = $value;
                        }
                        if ($key == 'created') {
                            $created = $value;
                        }
                        if ($key == 'orderId') {
                            $orderId = $value; 
                        }
                    }

                    // if created is not null, this means it is updated from administrator -- delete this order and recreate
                    if ($orderId != null) {
                        DB::table('orders')->where('id', $orderId)->delete();
                    }

                    // Save to orders table
                    $orderIdNew = $this->saveOrderTable($customerId, $totalQuantity, $totalPrice, $note, $created);

                    $keys = array_keys($items);
                    foreach ($keys as $key) {   // $key is serialNumber
                        $product = $items[$key]['productItem'];
                        $quantity = $items[$key]['quantity'];
                        $subItems = $items[$key]['subItems'];
                        $totalPricePerProductItem = $items[$key]['totalPricePerProductItem'];

                        // Save to order_products table
                        $summary = $this->retrieveProductSummary($product, $subItems, $totalPricePerProductItem);
                        $orderProductId = $this->saveOrderProductsTable($orderIdNew, $product->id, $quantity, $summary);

                        // Save to subItems tables
                        $this->saveSubItems($orderProductId, $subItems);
                    }

                    // ToDo -- Submit Credit Card Charge
                }
            } catch (Exception $e) {
                return $e;
            }
        });
        if (is_null($exception)) {
            // ToDo -- Send email to customer
            Session::forget('cart');
            if ($orderId != null) {
                return response()->json(['status'=>1, 'msg'=>'Your order has been submitted succussfully.', 'editOrder'=>true]);
            } else {
                return response()->json(['status'=>1, 'msg'=>'Your order has been submitted succussfully.']);
            }
        } else {
            return response()->json(['status'=>3, 'msg'=>$exception]);
        }
    }

    protected function retrieveCustomerId(Request $request) {
        if (Session::has('customer')) {
            $customer = Session::get('customer');
            $this->updateCardInformation($customer, $request);
            return $customer->id;
        } else {
            $customer = DB::table('customers')->where('email', $request->email)->first();
            if ($customer) {
                $this->updateCardInformation($customer, $request);
                return $customer->id;
            } else {
                $customerId = null;
                $customerId = DB::table('customers')->insertGetId([
                    'first_name'=>$request->firstname, 
                    'last_name'=>$request->lastname, 
                    'phone'=>$request->phone, 
                    'email'=>$request->email,
                    'zip'=>$request->zip,
                    'card_number'=>str_replace("-", "", $request->card),
                    'expired'=>str_replace("/", "", $request->expired),
                    'cvv'=>$request->cvv,
                ]);
                return $customerId;
            }
        }
    }

    protected function updateCardInformation($customer, $request) {
        if ($customer->card_number == null) {
            DB::table('customers')->where('id', $customer->id)
                ->update([
                    'zip'=>$request->zip,
                    'card_number'=>str_replace("-", "", $request->card),
                    'expired'=>str_replace("/", "", $request->expired),
                    'cvv'=>$request->cvv
                ]);
        }
    }

    protected function saveOrderTable($customerId, $quantity, $total, $note, $created) {
        $orderId = null;
        if ($created != null) {
            $orderId = DB::table('orders')->insertGetId([
                'customer_id'=>$customerId, 'quantity'=>$quantity, 'total'=>$total, 'note'=>$note, 'created_at'=>$created, 'updated_at'=>Carbon::now() 
            ]);
        } else {
            $orderId = DB::table('orders')->insertGetId([
                'customer_id'=>$customerId, 'quantity'=>$quantity, 'total'=>$total, 'note'=>$note, 'created_at'=>Carbon::now() 
            ]);
        }
        return $orderId;
    }

    protected function retrieveProductSummary($product, $subItems, $totalPricePerProductItem) {
        $productSummary = "";
        $subItemsSummary = retrieveSummary($subItems);
        $totalPriceDisplay = retrieveTotalPriceDisplay($product, $subItems, $totalPricePerProductItem);

        $productSummary .= $product->name ." (" .$product->description .")\n";
        if ($subItemsSummary != "") {
            $productSummary .= $subItemsSummary ."\n";
        }    
        $productSummary .= $totalPriceDisplay;
        return $productSummary;
    }

    protected function saveOrderProductsTable($orderId, $productId, $quantity, $summary) {
        $orderProductId = DB::table('order_products')->insertGetId([
            'order_id'=>$orderId, 'product_id'=>$productId, 'quantity'=>$quantity, 'summary'=>$summary
        ]);
        return $orderProductId;
    }

    protected function saveSubItems($orderProductId, $subItems) {
        if (($subItems == null) || count($subItems) == 0) {
            return;
        }

        $keys = array_keys($subItems);
        foreach ($keys as $key) {         
            $category = $subItems[$key]['category'];
            $quantity = $subItems[$key]['quantity'];
            $item = $subItems[$key]['item'];
            
            if ($category == "Side") {
                if (count($keys) > 1) { // This means combo not Individual Side/Entree                     
                    // Save to order_sub_sides table
                    DB::table('order_sub_sides')->insert([
                        'order_product_id'=>$orderProductId, 'quantity'=>$quantity, 'side_id'=>$item->id 
                    ]);
                } else {
                    // Save to order_sides table
                    DB::table('order_sides')->insert([
                        'order_product_id'=>$orderProductId, 'side_id'=>$item->id 
                    ]);
                } 
            }
            if ($category == "Entree") {
                if (count($keys) > 1) { // This means combo not Individual Side/Entree 
                    // Save to order_sub_entrees table
                    DB::table('order_sub_entrees')->insert([
                        'order_product_id'=>$orderProductId, 'quantity'=>$quantity, 'entree_id'=>$item->id 
                    ]);
                } else {
                    // Save to order_entrees table
                    DB::table('order_entrees')->insert([
                        'order_product_id'=>$orderProductId, 'entree_id'=>$item->id 
                    ]);
                }
            }
            if ($category == "Drink") {
                // Save to order_sub_drinks table
                $typeId = null;
                if (array_key_exists('selectDrink', $subItems[$key])) {
                     $selectDrink = $subItems[$key]['selectDrink'];
                     $typeId = $selectDrink->id;
                }
                DB::table('order_sub_drinks')->insert([
                    'order_product_id'=>$orderProductId, 'quantity'=>$quantity, 'drink_id'=>$item->id, 'type_id'=>$typeId
                ]);  
            }
            if ($category == "DrinkOnly") {
                // Save to order_drinks table
                $typeId = null;
                if (array_key_exists('selectDrink', $subItems[$key])) {
                     $selectDrink = $subItems[$key]['selectDrink'];
                     $typeId = $selectDrink->id;
                }
                DB::table('order_drinks')->insert([
                    'order_product_id'=>$orderProductId, 'drink_id'=>$item->id, 'type_id'=>$typeId
                ]);
            }
        }
    }
}
