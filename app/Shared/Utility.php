<?php
    namespace App\Shared;

    use App\Models\Product;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Shared\Cart;

    class Utility {

        /*public function loadSideChoices($sides)
        {
            $html = "";
            foreach($sides as $side) {
                $html .=        "<div class=\"col-md-4 text-center\">";
                $html .=            "<div class=\"choiceItemSide\" id=\"choiceItemSide" .$side->id ."\">";
                $html .=                "<img src=\"\\images\\" .$side->gallery ."\" style=\"width:60%\">";
                $html .=                "<br>";
                $html .=                "<span class=\"choiceItemSideName\" id=\"choiceItemSideName" .$side->id ."\">" .$side->name ."</span>";
                $html .=            "</div>";
                $html .=            "<div class=\"selectedDiv\">";
                $html .=                "<h3 class=\"sideSelected\" id=\"sideSelected" .$side->id ."\"></h3>";
                $html .=                "<div class=\"sideQuantityIncrementDiv mx-auto\" id=\"sideQuantityIncrementDiv" .$side->id ."\" style=\"display: none;\">";
                $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle sideQuantityMinus\" id=\"sideQuantityMinus" .$side->id ."\"><i class=\"fas fa-minus\"></i></button>";
                $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center sideQuantity\" value=\"0\" id=\"sideQuantity" .$side->id ."\" disabled>";
                $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle sideQuantityPlus\" id=\"sideQuantityPlus" .$side->id ."\"><i class=\"fas fa-plus\"></i></button>";
                $html .=                "</div>";
                $html .=            "</div>";
                $html .=        "</div>";
            }
            return $html;
        }*/

        public function cartCountSpanElement()
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

        public function checkoutElement()
        {
            $cart = new Cart(Session::get('cart'));
            $totalQuantity = $cart->totalQuantity;
            echo "<a class=\"nav-link " .(($totalQuantity>0)?"active":"") ."\" aria-current=\"page\" href=" .(($totalQuantity>0)?"/checkout":"javascript:void(0);") .">Checkout</a>";
        }

        public function orderListDivElement()
        {
            if (Session::has('cart')){
                $elements = "";
                $items = array();
                $totalQuantity = 0;
                $totalPrice = 0;
                $subItems = array();
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
                    $product = $items[$key]['productItem'];
                    $quantity = $items[$key]['quantity'];
                    $subItems = $items[$key]['subItems'];
                    $totalPricePerProductItem = $items[$key]['totalPricePerProductItem'];
                    $elements = $elements .$this->cartElement($key, $product, $quantity, $subItems, $totalPricePerProductItem);
                }
            } 
        }

        protected function cartElement($key, $product, $quantity, $subItems, $totalPricePerProductItem)
        {   // $key is serialNumber, using serialNumber instead of productId is the example like User can order many Regular Platters with different Sides and Entrees. But they are the same productId.
            $orderSummary = $this->retrieveSummary($subItems);
            $totalPriceDisplay = $this->retrieveTotalPriceDisplay($product, $subItems, $totalPricePerProductItem);
            
            // Handle image for Individaul Side/Entree and Drink
            $image = $product->gallery;
            if ($image == "") {
                $image = $this->retrieveImageFromSubItmes($subItems);
            }

            $element = "
                <form action=\"/cart\" method=\"get\" class=\"cart-items\">
                    <div class=\"border rounded\">
                        <div class=\"row bg-white\">
                            <div class=\"col-md-3\">
                                <img src=\"\images\\" .$image . "\" style=\"width: 100%\">     
                            </div>
                            <div class=\"col-md-6\">
                                <h5 class=\"pt-2\">" .$product->name ." <small>: " .$product->description ."</small> </h5>
                                <h5><small style=\"color:red\">" .$orderSummary ."</small> </h5>
                                <h5 class=\"pt-1\">" .$totalPriceDisplay ."</h5>
                                <div class=\"pb-1\">
                                    <button type=\"submit\" class=\"btn btn-warning edit\" id=\"edit" .$key ."AND" .$product->id ."\" data-bs-toggle=\"modal\" data-bs-target=\"#editModal\">Edit</button>
                                    <button type=\"button\" class=\"btn btn-danger mx-2 remove\" id=\"remove" .$key ."AND" .$product->id ."\">Remove</button>
                                </div>
                            </div>
                            <div class=\"col-md-3\">
                                <div class=\"py-5\">
                                    <button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinusForCart\" id=\"quantityMinusForCart" .$key ."AND" .$product->id ."\"><i class=\"fas fa-minus\"></i></button>
                                    <input type=\"text\" class=\"form-control w-25 d-inline text-center\" value=\"" .$quantity ."\" id=\"quantityForCart" .$key ."AND" .$product->id ."\" disabled>
                                    <button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlusForCart\" id=\"quantityPlusForCart" .$key ."AND" .$product->id ."\"><i class=\"fas fa-plus\"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            ";
            
            echo $element;
        }

        public function orderListDivElementForCheckout()
        {
            if (Session::has('cart')){
                $elements = "";
                $items = array();
                $totalQuantity = 0;
                $totalPrice = 0;
                $subItems = array();
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
                    $product = $items[$key]['productItem'];
                    $quantity = $items[$key]['quantity'];
                    $subItems = $items[$key]['subItems'];
                    $totalPricePerProductItem = $items[$key]['totalPricePerProductItem'];
                    $elements = $elements .$this->cartElementForCheckout($key, $product, $quantity, $subItems, $totalPricePerProductItem);
                }
            } 
        }

        protected function cartElementForCheckout($key, $product, $quantity, $subItems, $totalPricePerProductItem)
        {   // $key is serialNumber, using serialNumber instead of productId is the example like User can order many Regular Platters with different Sides and Entrees. But they are the same productId.
            $orderSummary = $this->retrieveSummary($subItems);
            $totalPriceDisplay = $this->retrieveTotalPriceDisplay($product, $subItems, $totalPricePerProductItem);
            
            // Handle image for Individaul Side/Entree and Drink
            $image = $product->gallery;
            if ($image == "") {
                $image = $this->retrieveImageFromSubItmes($subItems);
            }

            $element = " 
                <div class=\"border rounded\">
                    <div class=\"row bg-white\">
                        <div class=\"col-md-3\">
                            <img src=\"\images\\" .$image . "\" style=\"width: 100%\">                  
                        </div>
                        <div class=\"col-md-9\">
                            <h5 class=\"pt-2\">" .$product->name ." <small>: " .$product->description ."</small> </h5>
                            <h5><small>" .$orderSummary ."</small> </h5>
                            <h5 class=\"pt-1\">" .$totalPriceDisplay ." -- " .$quantity .(($quantity>1)?" items":" item") ."</h5>
                        </div>
                    </div>
                </div>
                <br>
            ";
            
            echo $element;
        }

        public function retrieveSummary($subItems) {
            $summary = "";
            $side = "";
            $entree = "";
            $drink = "";
            $drinkOnly = "";

            if (($subItems == null) || count($subItems) == 0) {
                return $summary;
            }

            $keys = array_keys($subItems);
            foreach ($keys as $key) {         
                $category = $subItems[$key]['category'];
                $quantity = $subItems[$key]['quantity'];
                $item = $subItems[$key]['item'];
                
                if ($quantity == 0.5) {
                    $quantity = "1/2";
                }
                if ($category == "Side") {
                    if (count($keys) > 1) { // This means combo not Individual Side/Entree 
                        $side = $side .$item->name ."(" .$quantity .") ";
                    } else {
                        $side = $side .$item->name ." ";
                    } 
                }
                if ($category == "Entree") {
                    if (count($keys) > 1) { // This means combo not Individual Side/Entree 
                        $entree = $entree .$item->name ."(" .$quantity .") ";
                    } else {
                        $entree = $entree .$item->name ." ";
                    }
                }
                if ($category == "Drink") {
                    $selectDrinkSummary = "";
                    if (array_key_exists('selectDrink', $subItems[$key])) {
                        $selectDrink = $subItems[$key]['selectDrink'];
                        $selectDrinkSummary = " - " .$selectDrink->name;
                    }
                    if ($item->price > 0) {
                        $drink = $drink .$item->name ." - extra charge: $" .number_format($item->price, 2, '.', ',');
                    } else {
                        $drink = $drink .$item->name .$selectDrinkSummary;
                    }     
                }
                if ($category == "DrinkOnly") {
                    $selectDrinkSummary = "";
                    if (array_key_exists('selectDrink', $subItems[$key])) {
                        $selectDrink = $subItems[$key]['selectDrink'];
                        $selectDrinkSummary = "Flavor: " .$selectDrink->name;
                        $drinkOnly = $drinkOnly .$selectDrinkSummary;
                    }
                }
            }

            if ($side != "") {
                $summary .= "Side: " .$side;
            }
            if ($entree != "") {
                $summary .= "Entree: " .$entree;
            }
            if ($drink != "") {
                $summary .= "Drink: " .$drink;
            }
            if ($drinkOnly != "") {
                $summary .= $drinkOnly;
            }

            return $summary;
        }

        public function retrieveTotalPriceDisplay($product, $subItems, $totalPricePerProductItem) {
            $totalPriceDisplay = "";

            $extraCharge = $this->retrieveExtraCharge($subItems);
            if ($extraCharge > 0) {
                $totalPriceDisplay .= "$" .number_format($product->price, 2, '.', ',') ." + $" .number_format($extraCharge, 2, '.', ',') ." = $" .number_format($totalPricePerProductItem, 2, '.', ',');
            } else {
                $totalPriceDisplay .= "$" .number_format($product->price, 2, '.', ',');
            }

            return $totalPriceDisplay;
        }

        protected function retrieveExtraCharge($subItems) {
            $extraCharge = 0;

            if (($subItems == null) || count($subItems) == 0) {
                return $extraCharge;
            }

            $keys = array_keys($subItems);
            foreach ($keys as $key) {         
                $category = $subItems[$key]['category'];
                $quantity = $subItems[$key]['quantity'];
                $item = $subItems[$key]['item'];
                
                if ($category == "Drink") {
                    if ($item->price > 0) {
                        $extraCharge = $extraCharge + $item->price; // This item is from combodrinks table
                    }
                }
            }

            return $extraCharge;
        }

        protected function retrieveImageFromSubItmes($subItems) {
            // This case for Individual Side/Entree, it should just have one subItem in $subItems
                //$category = $subItems[$key]['category'];  --> if this is Side
                //$quantity = $subItems[$key]['quantity'];
                //$item = $subItems[$key]['item'];          --> Then, this will be the record from sides table

            $image = "";

            /*if (($subItems == null) || count($subItems) == 0) {
                return $image;
            }*/

            if (($subItems != null) && count($subItems) != 0) {
                $keys = array_keys($subItems);
                foreach ($keys as $key) {
                    $item = $subItems[$key]['item'];
                    $image = $item->gallery;
                }
            }    

            return $image;
        }

        public function priceDetailDivElement()
        {
            $priceDetail = $this->retrievePriceDetail();
            $disabledOrNot = ($priceDetail['totalQuantity']>0)?"":"disabled";
            $element = "
                <div>
                    <h5>Price Detail</h5>
                </div>
                <hr>
                <div class=\"row px-5\">
                    <div class=\"col-md-6 text-start\">
                        <h5>Price (" .$priceDetail['totalQuantity'] ." items)</h5>
                        <h5>Tax</h5>
                        <hr>
                        <h4>Order Total</h4>
                    </div>
                    <div class=\"col-md-6 text-end\">
                        <h5>$" .$priceDetail['totalPrice'] ."</h5>
                        <h5>$" .$priceDetail['tax'] ."</h5>
                        <hr>
                        <h4>$" .$priceDetail['total'] ."</h4>
                    </div>
                </div>
                <br>
                <div class=\"text-center\">
                    <button style=\"width: 30%\" type=\"button\" class=\"btn btn-primary\" id=\"checkout\" " .$disabledOrNot .">Checkout</button>
                    <button style=\"width: 30%\" type=\"button\" class=\"btn btn-danger\" id=\"emptycart\">Empty Cart</button>
                </div>
            ";
            echo $element;
        }

        public function retrievePriceDetail()
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

        public function priceDetailDivElementForCheckout()
        {
            $priceDetail = $this->retrievePriceDetail();
            $element = "
                <div class=\"row px-5\">
                    <div class=\"col-md-6 text-start\">
                        <h5>Subtotal (" .$priceDetail['totalQuantity'] ." items)</h5>
                        <h5>Tax</h5>
                        <hr>
                        <h4>Order Total</h4>
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

        /*public function loadQuantityIncrementDivElelemt()
        {
            $html = "";
            $html .=    "<div class=\"quantityDiv mx-auto\">";
            $html .=        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$product->id ."\"><i class=\"fas fa-minus\"></i></button>";
            $html .=        "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"1\" id=\"quantity" .$product->id ."\" disabled>";
            $html .=        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$product->id ."\"><i class=\"fas fa-plus\"></i></button>";
            $html .=    "</div>";

            return $html;
        }*/

        public function orderNoteDivElementForCheckout() 
        {
            $note = "";
            if (Session::has('cart')){
                $cart = new Cart(Session::get('cart'));
                $note = $cart->note;
            }

            $element = "
                <div class=\"row px-5\">
                    <div class=\"col-md-12 text-start\">
                        <p style=\"font-size: 20px\">Special Reqests: " .$note ."</p>
                    </div>
                </div>
                <hr>
                <br>
            ";
            echo $element;
        }
    }