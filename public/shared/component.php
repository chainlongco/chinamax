<?php
    use App\Models\Product;
    use Illuminate\Http\Request;

    function updateSessionData(Request $request)
    {
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
    }

    function retrieveIdListFromSession()
    {
        $idArray = [];
        $productsArray = Session::get('cart');
        foreach($productsArray as $key=>$value){
            array_push($idArray, $productsArray[$key]['productId']);
        }
        return $idArray;
    }

    function cartCountSpanElement()
    {
        if (Session::has('cart')) {
            $count = 0;
            foreach (Session::get('cart') as $products){
                foreach($products as $key=>$value) {
                    if ($key == "quantity") {
                        $count = $count + (int)$value;
                    }
                }
            }
            echo "<span id=\"cart_count\" class=\"text-warning bg-light\">" .$count ."</span>";
        } else {
            echo "<span id=\"cart_count\" class=\"text-warning bg-light\">0</span>";
        }
    }

    function orderListDivElement()
    {
        if (Session::has('cart')){
            foreach (Session::get('cart') as $products){
                $elements = "";
                $quantity = 0;
                $product = null;
                foreach($products as $key=>$value) {              
                    if ($key == "productId") {
                        $product = Product::find($value);
                    }
                    if ($key == "quantity") {
                        $quantity = $value;
                    }            
                }
                if ($product != null) {
                    $elements = $elements .cartElement($product, $quantity);
                }       
            }     
        } 
    }

    //function cartElement($imageName, $productName, $productDescription, $price, $quantity)
    function cartElement($product, $quantity)
    {
        //print_r($imageName);
        $element = "
            <form action=\"/cart\" method=\"get\" class=\"cart-items\">
                <div class=\"border rounded\">
                    <div class=\"row bg-white\">
                        <div class=\"col-md-3\">
                            <img src=\"\images\\" .$product->gallery . "\" style=\"width: 100%\">
                                      
                        </div>
                        <div class=\"col-md-6\">
                            <h5 class=\"pt-2\">" .$product->name ."</h5>
                            <small class=\"text-secondary\">" .$product->description ."</small>
                            <h5 class=\"pt-1\">$" .$product->price ."</h5>
                            <div class=\"pb-1\">
                                <button type=\"submit\" class=\"btn btn-warning\">Save for Later</button>
                                <button type=\"button\" class=\"btn btn-danger mx-2 remove\" id=\"remove" .$product->id ."\">Remove</button>
                            </div>
                        </div>
                        <div class=\"col-md-3\">
                            <div class=\"py-5\">
                                <button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$product->id ."\"><i class=\"fas fa-minus\"></i></button>
                                <input type=\"text\" class=\"form-control w-25 d-inline\" value=\"" .$quantity ."\" id=\"quantity" .$product->id ."\">
                                <button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$product->id ."\"><i class=\"fas fa-plus\"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        ";
        echo $element;
    }

    function priceDetaiDivElement()
    {
        $priceDetail = retrievePriceDetail();
        $element = "
            <h5>Price Detail</h5>
            <hr>
            <div class=\"row px-5\">
                <div class=\"col-md-6 text-start\">
                    <h5>Price (" .$priceDetail['items'] ." items)</h5>
                    <h5>Tax</h5>
                    <hr>
                    <h3>Order Total</h3>
                </div>
                <div class=\"col-md-6 text-end\">
                    <h5>$" .$priceDetail['subtotal'] ."</h5>
                    <h5>$" .$priceDetail['tax'] ."</h5>
                    <hr>
                    <h4>$" .$priceDetail['total'] ."</h4>
                </div>
            </div>
        ";
        echo $element;
    }

    function retrievePriceDetail()
    {
        $subtotal = 0;
        $items = 0;
        $tax = 0;
        $total = 0;
        $taxRate = 0.0825;
        if (Session::has('cart')){
            foreach (Session::get('cart') as $products){
                $quantity = 0;
                $product = null;
                foreach($products as $key=>$value) {              
                    if ($key == "productId") {
                        $product = Product::find($value);
                    }
                    if ($key == "quantity") {
                        $quantity = $value;
                    }        
                }
                if ($product != null) {
                    $items += $quantity;
                    $subtotal += (floatval($product->price)) * $quantity;
                }       
            }
            $tax = round(($subtotal * $taxRate), 2);
            $total = $subtotal + $tax;
        }
        $priceDetail = array('items'=>$items, 'subtotal'=>number_format($subtotal, 2, '.', ','), 'tax'=>number_format($tax, 2, '.', ','), 'total'=>number_format($total, 2, '.', ','));
        return $priceDetail;
    } 

    function orderMenuElement($menus)
    {
        $element = "
            <h1>Menu</h1>
        ";
            foreach($menus as $menu) {
                $element = $element ."
                    <div class=\"eachMenu\">
                        <div class=\"menuItem\">
                            <span class=\"menuItemName\">" .$menu->name ."</span>
                ";
                if ((string)($menu->price) !== '0') {
                    $element = $element ."
                            <br>
                            <span class=\"menuItemPrice\">$" .$menu->price ."</span>
                    ";    
                }
                $element = $element ."
                            <br>
                        </div>
                        <span class=\"menuItemDescription\">" .$menu->description ."</span>
                    </div>
                    <br>
                ";
            }

        echo $element;    
    }

?>