<?php
    use App\Models\Product;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use App\Shared\Cart;

    function loadAppetizesChoices($menuName)
    {
        $quantity = 0;
        $html = "";
        $products = DB::table('products')->where('menu_id', "1")->get();
        $html .= "<h1>Choices for " .$menuName ."</h1>";
        $html .= "<div class=\"row\">";
        foreach ($products as $product) {
            $html .= "<div class=\"col-md-4 text-center\">";
                $html .= "<div class=\"choiceItem\">";
                    $html .= "<img src=\"\\images\\" .$product->gallery ."\" style=\"width:60%\">";
                    $html .= "<br>";
                    $html .= "<span class=\"choiceItemName\">" .$product->name ."</span>";
                    $html .= "<br>";
                    $html .= "<span class=\"choiceItemPrice\">$" .$product->price ."</span>";
                    $html .= "<br>";
                    $html .= "<div class=\"quantityDiv mx-auto\">
                                <button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$product->id ."\"><i class=\"fas fa-minus\"></i></button>
                                <input type=\"text\" class=\"form-control w-25 d-inline text-center\" value=\"" .$quantity ."\" id=\"quantity" .$product->id ."\" disabled>
                                <button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$product->id ."\"><i class=\"fas fa-plus\"></i></button>
                              </div>";
                    $html .= "<div>
                                <button type=\"button\" class=\"btn bg-light border addToCart\" disabled id=\"addToCart" .$product->id ."\">Add to Cart</button>
                              </div>";          
                $html .= "</div>";
            $html .= "</div>";
        }
        
        $html .= "</div>";
        return $html;

        /*
        <div class="row">
            @foreach($appetizers as $appetizer)
            <div class="col-md-4 text-center">
                <div class="choiceItem">
                    <img src="\images\{{ $appetizer->gallery }}" style="width:60%">
                    <br>
                    <span class="choiceItemName">{{ $appetizer->name }}</span>
                    <br>
                    <span class="choiceItemPrice">${{ $appetizer->price }}</span>
                </div>
            </div>
            @endforeach
        </div>*/
    }

    function loadDrinksChoices($menuName) 
    {
        $html = "";
        //$products = DB::table('products')->where('menu_id', "1")->get();
        $html .= "<h1>Choices for " .$menuName ."</h1>";

        return $html;
    }

    function loadIndividualEntreeChoices($menuName)
    {
        $html = "";
        //$products = DB::table('products')->where('menu_id', "1")->get();
        $html .= "<h1>Choices for " .$menuName ."</h1>";

        return $html;
    }

    function loadSmallPlatterChoices($menuName)
    {
        $html = "";
        //$products = DB::table('products')->where('menu_id', "1")->get();
        $html .= "<h1>Choices for " .$menuName ."</h1>";

        return $html;
    }

    function loadRegularPlatterChoices($menuName)
    {
        $html = "";
        //$products = DB::table('products')->where('menu_id', "1")->get();
        $html .= "<h1>Choices for " .$menuName ."</h1>";

        return $html;
    }

    function loadLargePlatterChoices($menuName)
    {
        $html = "";
        //$products = DB::table('products')->where('menu_id', "1")->get();
        $html .= "<h1>Choices for " .$menuName ."</h1>";

        return $html;
    }

    function loadPartyTrayChoices($menuName)
    {
        $html = "";
        //$products = DB::table('products')->where('menu_id', "1")->get();
        $html .= "<h1>Choices for " .$menuName ."</h1>";

        return $html;
    }

    function loadKidsMealChoices($menuName)
    {
        $html = "";
        //$products = DB::table('products')->where('menu_id', "1")->get();
        $html .= "<h1>Choices for " .$menuName ."</h1>";

        return $html;
    }

    function cartCountSpanElement()
    {
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $count = 0;
            if ($cart) {
                $count = $cart->totalQuantity;
            }
            echo "<span id=\"cart_count\" class=\"text-warning bg-light\">" .$count ."</span>";
        } else {
            echo "<span id=\"cart_count\" class=\"text-warning bg-light\">0</span>";
        }
    }

    function orderListDivElement()
    {
        if (Session::has('cart')){
            $elements = "";
            $items = array();
            $totalQuantity = 0;
            $totalPrice = 0;
            $subItem = array();
            foreach (Session::get('cart') as $key=>$value) {
               if ($key == 'totalQuantity') {
                   $totalQuantity = $value;
               }
               if ($key == 'totalPrice') {
                   $totalPrice = $value;
               }
               if ($key == 'items') {
                   $items = $value;
               }
            }
            $keys = array_keys($items);
            foreach ($keys as $key) {   // $key is serialNumber
                $product = $items[$key]['item'];
                $quantity = $items[$key]['quantity'];
                $subItem = $items[$key]['subItem'];
                $elements = $elements .cartElement($key, $product, $quantity, $subItem);
            }
        } 
    }

    function cartElement($key, $product, $quantity, $subItem)
    {   // $key is serialNumber, using serialNumber instead of productId is the example like User can order many Regular Platters with different Sides and Entrees. But they are the same productId.
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
                                <button type=\"submit\" class=\"btn btn-warning\">Edit</button>
                                <button type=\"button\" class=\"btn btn-danger mx-2 remove\" id=\"remove" .$key ."AND" .$product->id ."\">Remove</button>
                            </div>
                        </div>
                        <div class=\"col-md-3\">
                            <div class=\"py-5\">
                                <button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$key ."AND" .$product->id ."\"><i class=\"fas fa-minus\"></i></button>
                                <input type=\"text\" class=\"form-control w-25 d-inline text-center\" value=\"" .$quantity ."\" id=\"quantity" .$key ."AND" .$product->id ."\" disabled>
                                <button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$key ."AND" .$product->id ."\"><i class=\"fas fa-plus\"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        ";
        echo $element;
    }

    function priceDetailDivElement()
    {
        $priceDetail = retrievePriceDetail();
        $element = "
            <h5>Price Detail</h5>
            <hr>
            <div class=\"row px-5\">
                <div class=\"col-md-6 text-start\">
                    <h5>Price (" .$priceDetail['totalQuantity'] ." items)</h5>
                    <h5>Tax</h5>
                    <hr>
                    <h3>Order Total</h3>
                </div>
                <div class=\"col-md-6 text-end\">
                    <h5>$" .$priceDetail['totalPrice'] ."</h5>
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
        $totalQuantity = 0;
        $totalPrice = 0;
        $tax = 0;
        $total = 0;
        $taxRate = 0.0825;
        if (Session::has('cart')){
            $cart = new Cart(Session::get('cart'));
            $totalQuantity = $cart->totalQuantity;
            $totalPrice = $cart->totalPrice; 
            /*foreach (Session::get('cart') as $key=>$value) {
               if ($key == 'totalQuantity') {
                   $totalQuantity = $value;
               }
               if ($key == 'totalPrice') {
                   $totalPrice = $value;
               }
            }*/
        }
        $tax = round(($totalPrice * $taxRate), 2);
        $total = $totalPrice + $tax;
        $priceDetail = array('totalQuantity'=>$totalQuantity, 'totalPrice'=>number_format($totalPrice, 2, '.', ','), 'tax'=>number_format($tax, 2, '.', ','), 'total'=>number_format($total, 2, '.', ','));
        return $priceDetail;
    }

?>