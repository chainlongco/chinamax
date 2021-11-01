<?php
    use App\Models\Product;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use App\Shared\Cart;

    function loadAppetizesChoices($menu)
    {
        $quantity = 0;
        $html = "";
        $products = DB::table('products')->where('menu_id', $menu->id)->get();
        $html .= "<h1>Choices for " .$menu->name ."</h1>";
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
                                <input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"" .$quantity ."\" id=\"quantity" .$product->id ."\" disabled>
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

        $drinks = DB::table('drinks')->get();
        $html .= "<h1>Choices for " .$menuName ."</h1>";
        $html .= "<div class=\"row\">";
                    foreach ($drinks as $drink) {
                        $productDrinks = DB::table('products')->where('category', $drink->name)->get();
                        if (count($productDrinks)==1) {
                            $productDrink = $productDrinks[0];
        $html .=            "<div class=\"col-md-4 text-center\">";
        $html .=                "<div class=\"choiceItemDrink\" id=\"choiceItemDrink" .$drink->id ."\">";
        $html .=                    "<input type=\"hidden\" id=\"productId" .$drink->id ."\" value=\"" .$productDrink->id ."\"/>";
        $html .=                    "<img src=\"\\images\\" .$drink->gallery ."\" style=\"width:60%\">";
        $html .=                    "<br>";
                                    $tableName = $drink->tablename;
                                    $price = number_format($productDrink->price, 2, '.', ',');
                                    if ($tableName!="") {
        $html .=                        "<span class=\"choiceItemDrinkName\" id=\"choiceItemDrinkName" .$drink->id ."\">" .$drink->name ." -- $" .$price ."</span>";
        $html .=                        "<div style=\"padding-top:10px; font-size:20px;\">";
        $html .=                            "<select name=\"selectDrink\" class=\"selectDrink\" id=\"selectDrink" .$drink->id ."\" style=\"height: 37px; padding: 0px 10px; \">";
        $html .=                                "<option value=0 selected disable>Choose the flavor</option>";
                                                $drinkLists = DB::table($tableName)->get(); // this is for cans table
                                                foreach ($drinkLists as $drinkList) {
        $html .=                                    "<option value=" .$drinkList->id .">" .$drinkList->name ."</option>";
                                                }
        $html .=                            "</select>";
        $html .=                        "</div>";
                                    } else {
        $html .=                        "<span class=\"choiceItemDrinkName\" id=\"choiceItemDrinkName" .$drink->id ."\">" .$drink->name ."</span>";
        $html .=                        "<br>";
        $html .=                        "<span class=\"choiceItemPrice\">$" .$price ."</span>";
        $html .=                        "<br>";
                                    }
        $html .=                    "<div class=\"quantityDiv mx-auto\">";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$drink->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                        "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"0\" id=\"quantity" .$drink->id ."\" disabled>";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$drink->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                    "</div>";
        $html .=                    "<div>";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border addToCartForDrinkOnly\" id=\"addToCartForDrinkOnly" .$drink->id ."\" disabled>Add to Cart</button>";
        $html .=                    "</div>";
        $html .=                "</div>";
        $html .=                "<br>";
        $html .=            "</div>";
                        } else {
                            $tableName = $drink->tablename;           
        $html .=            "<div class=\"col-md-4 text-center\">";
        $html .=                "<div class=\"choiceItemDrink\" id=\"choiceItemDrink" .$drink->id ."\">";
        $html .=                    "<img src=\"\\images\\" .$drink->gallery ."\" style=\"width:60%\">";
        $html .=                    "<br>"; 
        $html .=                    "<span class=\"choiceItemDrinkName\" id=\"choiceItemDrinkName" .$drink->id ."\">" .$drink->name ."</span>";
        $html .=                    "<div style=\"padding-top:10px; font-size:20px;\">";
        $html .=                        "<select name=\"selectDrink\" class=\"selectDrink\" id=\"selectDrink" .$drink->id ."\" style=\"height: 37px; padding: 0px 10px; \">";
        $html .=                            "<option value=0 selected disable>Choose the flavor</option>";                                                
                                            $drinkLists = DB::table($tableName)->get(); // this is for fountains and juices table
                                            foreach ($drinkLists as $drinkList) {                                                     
        $html .=                                "<option value=" .$drinkList->id .">" .$drinkList->name ."</option>";
                                            }
        $html .=                        "</select>";
        $html .=                    "</div>";
        $html .=                    "<div style=\"padding-top:10px; font-size:20px;\">";
        $html .=                        "<select name=\"productDrinks\" id=\"productDrinks" .$drink->id ."\" style=\"height: 37px; padding: 0px 10px; \">";
                                            foreach ($productDrinks as $productDrink) {
        $html .=                                "<option value=" .$productDrink->id ."\">" .$productDrink->name ." - $" .$productDrink->price ."</option>";
                                            }
        $html .=                        "</select>";
        $html .=                    "</div>";
        $html .=                    "<div class=\"quantityDiv mx-auto\">";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$drink->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                        "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"0\" id=\"quantity" .$drink->id ."\" disabled>";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$drink->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                    "</div>";
        $html .=                    "<div>";
        $html .=                        "<button type=\"button\" class=\"btn bg-light border addToCartForDrinkOnly\" id=\"addToCartForDrinkOnly" .$drink->id ."\" disabled>Add to Cart</button>";
        $html .=                    "</div>";
        $html .=                "</div>";
        $html .=                "<br>";
        $html .=            "</div>";  
                        }
                    }
        $html .= "</div>";

        return $html;


                    /*<h1>Choices for Drink</h1>
                    <div class="row">
                        <?php
                            foreach ($drinks as $drink) {
                                $productDrinks = DB::table('products')->where('category', $drink->name)->get();
                                if (count($productDrinks)==1) {
                                    $productDrink = $productDrinks[0];
                        ?>
                                    <div class="col-md-4 text-center">
                                        <div class="choiceItemDrink" id="choiceItemDrink{{ $drink->id }}">
                                            <input type="hidden" id="productId{{ $drink->id }}" value="{{ $productDrink->id }}"/>
                                            <img src="\images\{{ $drink->gallery }}" style="width:60%">
                                            <br>
                                            
                                            <?php
                                                $tableName = $drink->tablename;
                                                $price = number_format($productDrink->price, 2, '.', ',');
                                                if ($tableName!="") {
                                            ?>

                                                    <span class="choiceItemDrinkName" id="choiceItemDrinkName{{ $drink->id }}">{{ $drink->name }} -- ${{ $price }}</span>
                                                    <div style="padding-top:10px; font-size:20px;">
                                                        <select name="selectDrink" class="selectDrink" id="selectDrink{{ $drink->id }}" style="height: 37px; padding: 0px 10px; ">
                                                            <option value=0 selected disable>Choose the flavor</option>
                                                            <?php
                                                                $drinkLists = DB::table($tableName)->get(); // this is for cans table
                                                                foreach ($drinkLists as $drinkList) {
                                                            ?>        
                                                                    <option value={{ $drinkList->id }}>{{ $drinkList->name }}</option>
                                                            <?php
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>

                                            <?php
                                                } else {
                                            ?>

                                                <span class="choiceItemDrinkName" id="choiceItemDrinkName{{ $drink->id }}">{{ $drink->name }}</span>
                                                <br>
                                                <span class="choiceItemPrice">${{ $price }}</span>
                                                <br>

                                            <?php
                                                }
                                            ?>

                                            <div class="quantityDiv mx-auto">
                                                <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus{{ $drink->id }}"><i class="fas fa-minus"></i></button>
                                                <input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity{{ $drink->id }}" disabled>
                                                <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus{{ $drink->id }}"><i class="fas fa-plus"></i></button>
                                            </div>
                                            <div>
                                                <button type="button" class="btn bg-light border addToCartForDrinkOnly" id="addToCartForDrinkOnly{{ $drink->id }}" disabled>Add to Cart</button>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                        <?php
                                } else {
                                    $tableName = $drink->tablename;
                        ?>            
                                    <div class="col-md-4 text-center">
                                        <div class="choiceItemDrink" id="choiceItemDrink{{ $drink->id }}">
                                            <img src="\images\{{ $drink->gallery }}" style="width:60%">
                                            <br> 

                                            <span class="choiceItemDrinkName" id="choiceItemDrinkName{{ $drink->id }}">{{ $drink->name }}</span>
                                            <div style="padding-top:10px; font-size:20px;">
                                                <select name="selectDrink" class="selectDrink" id="selectDrink{{ $drink->id }}" style="height: 37px; padding: 0px 10px; ">
                                                    <option value=0 selected disable>Choose the flavor</option>
                                                    <?php
                                                        $drinkLists = DB::table($tableName)->get(); // this is for fountains and juices table
                                                        foreach ($drinkLists as $drinkList) {
                                                    ?>        
                                                            <option value={{ $drinkList->id }}>{{ $drinkList->name }}</option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div style="padding-top:10px; font-size:20px;">
                                                <select name="productDrinks" id="productDrinks{{ $drink->id }}" style="height: 37px; padding: 0px 10px; ">
                                                    @foreach ($productDrinks as $productDrink)
                                                        <option value={{ $productDrink->id }}>{{ $productDrink->name }} - ${{ $productDrink->price }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="quantityDiv mx-auto">
                                                <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus{{ $drink->id }}"><i class="fas fa-minus"></i></button>
                                                <input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity{{ $drink->id }}" disabled>
                                                <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus{{ $drink->id }}"><i class="fas fa-plus"></i></button>
                                            </div>
                                            <div>
                                                <button type="button" class="btn bg-light border addToCartForDrinkOnly" id="addToCartForDrinkOnly{{ $drink->id }}" disabled>Add to Cart</button>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                        <?php  
                                }
                            }    
                        ?>
                    </div>*/
    }

    function loadComboChoices($product)
    {
        $sides = DB::table('sides')->get();
        $chickenEntrees = DB::table('entrees')->where('category', 'Chicken')->get();
        $beefEntrees = DB::table('entrees')->where('category', 'Beef')->get();
        $shrimpEntrees = DB::table('entrees')->where('category', 'Shrimp')->get();
        $combo = DB::table('combos')->where('product_id', $product->id)->first();
        $sideQuantitySummary = "Choose " .$combo->side ." Side";
        $entreeQuantitySummary = "Choose " .$combo->entree ." Entree";
        if ($combo->side == 1) {
            $sideQuantitySummary .= " (or Half/Half)";
        } else {
            $sideQuantitySummary .= "s";
        }
        if ($combo->entree > 1) {
            $entreeQuantitySummary .= "s";
        }

        $html = "";
        $html .= "<h1>Choices for " .$product->name ."</h1>";
        $html .= "<div class=\"row\">";
        $html .=    "<div class=\"text-start\">";
        $html .=        "<br>";
        $html .=        "<h3>" .$sideQuantitySummary ."</h3>";
        $html .=        "<input type=\"hidden\" id=\"sideMaxQuantity\" value=\"" .$combo->side ."\"/>";
        $html .=        "<br>";
        $html .=    "</div>";
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
        $html .=    "<div class=\"text-start\">";
        $html .=        "<br>";
        $html .=        "<br>";
        $html .=        "<h3>" .$entreeQuantitySummary ."</h3>";
        $html .=        "<input type=\"hidden\" id=\"entreeMaxQuantity\" value=\"" .$combo->entree ."\"/>";
        $html .=        "<h5>Chicken</h5>";
        $html .=    "</div>";
                    foreach($chickenEntrees as $chickenEntree) {
        $html .=        "<div class=\"col-md-4 text-center\">";
        $html .=            "<div class=\"choiceItemEntree\" id=\"choiceItemEntree" .$chickenEntree->id ."\">";
        $html .=                "<img src=\"\\images\\" .$chickenEntree->gallery ."\" style=\"width:60%\">";
        $html .=                "<br>";
        $html .=                "<span class=\"choiceItemEntreeName\" id=\"choiceItemEntreeName" .$chickenEntree->id ."\">" .$chickenEntree->name ."</span>";  
        $html .=            "</div>";
        $html .=            "<div class=\"selectedDiv\">";
        $html .=                "<h3 class=\"entreeSelected\" id=\"entreeSelected" .$chickenEntree->id ."\"></h3>";
        $html .=                "<div class=\"entreeQuantityIncrementDiv mx-auto\" id=\"entreeQuantityIncrementDiv" .$chickenEntree->id ."\" style=\"display: none;\">";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityMinus\" id=\"entreeQuantityMinus" .$chickenEntree->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center entreeQuantity\" value=\"0\" id=\"entreeQuantity" .$chickenEntree->id ."\" disabled>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityPlus\" id=\"entreeQuantityPlus" .$chickenEntree->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                "</div>";
        $html .=            "</div>";
        $html .=            "<br>";
        $html .=        "</div>";
                    }
        $html .=    "<div class=\"text-start\">";
        $html .=        "<br>";
        $html .=        "<h5>Beef</h5>";
        $html .=    "</div>";
                    foreach($beefEntrees as $beefEntree) {
        $html .=        "<div class=\"col-md-4 text-center\">";
        $html .=            "<div class=\"choiceItemEntree\" id=\"choiceItemEntree" .$beefEntree->id ."\">";
        $html .=                "<img src=\"\\images\\" .$beefEntree->gallery ."\" style=\"width:60%\">";
        $html .=                "<br>";
        $html .=                "<span class=\"choiceItemEntreeName\" id=\"choiceItemEntreeName" .$beefEntree->id ."\">" .$beefEntree->name ."</span>";  
        $html .=            "</div>";
        $html .=            "<div class=\"selectedDiv\">";
        $html .=                "<h3 class=\"entreeSelected\" id=\"entreeSelected" .$beefEntree->id ."\"></h3>";
        $html .=                "<div class=\"entreeQuantityIncrementDiv mx-auto\" id=\"entreeQuantityIncrementDiv" .$beefEntree->id ."\" style=\"display: none;\">";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityMinus\" id=\"entreeQuantityMinus" .$beefEntree->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center entreeQuantity\" value=\"0\" id=\"entreeQuantity" .$beefEntree->id ."\" disabled>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityPlus\" id=\"entreeQuantityPlus" .$beefEntree->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                "</div>";
        $html .=            "</div>";
        $html .=            "<br>";
        $html .=        "</div>";
                    }
        $html .=    "<div class=\"text-start\">";
        $html .=        "<br>";
        $html .=        "<h5>Shrimp</h5>";
        $html .=    "</div>";
                    foreach($shrimpEntrees as $shrimpEntree) {
        $html .=        "<div class=\"col-md-4 text-center\">";
        $html .=            "<div class=\"choiceItemEntree\" id=\"choiceItemEntree" .$shrimpEntree->id ."\">";
        $html .=                "<img src=\"\\images\\" .$shrimpEntree->gallery ."\" style=\"width:60%\">";
        $html .=                "<br>";
        $html .=                "<span class=\"choiceItemEntreeName\" id=\"choiceItemEntreeName" .$shrimpEntree->id ."\">" .$shrimpEntree->name ."</span>";  
        $html .=            "</div>";
        $html .=            "<div class=\"selectedDiv\">";
        $html .=                "<h3 class=\"entreeSelected\" id=\"entreeSelected" .$shrimpEntree->id ."\"></h3>";
        $html .=                "<div class=\"entreeQuantityIncrementDiv mx-auto\" id=\"entreeQuantityIncrementDiv" .$shrimpEntree->id ."\" style=\"display: none;\">";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityMinus\" id=\"entreeQuantityMinus" .$shrimpEntree->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center entreeQuantity\" value=\"0\" id=\"entreeQuantity" .$shrimpEntree->id ."\" disabled>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle entreeQuantityPlus\" id=\"entreeQuantityPlus" .$shrimpEntree->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                "</div>";
        $html .=            "</div>";
        $html .=            "<br>";
        $html .=        "</div>";
                    }

        // For Kid's Meal drink
        if ($combo->drink > 0) {
            //$productFountain = DB::table('products')->where('id', 29)->first();
            //$productWater = DB::table('products')->where('id', 5)->first();
            //$fountains = DB::table('fountains')->get();
            $drinkQuantitySummary = "Choose " .$combo->drink ." Drink (Default: Small Fountain Drink)";
            $comboDrinks = DB::table('combodrinks')->get();

            $html .=    "<div class=\"text-start\">";
            $html .=        "<br>";
            $html .=        "<h3>" .$drinkQuantitySummary ."</h3>";
            $html .=        "<input type=\"hidden\" id=\"drinkMaxQuantity\" value=\"" .$combo->drink ."\"/>";
            $html .=        "<br>";
            $html .=    "</div>";
                        foreach($comboDrinks as $comboDrink) {
                            if ($comboDrink->tablename != "") {
                                $tableNameForSelect = $comboDrink->tablename;
                                $listItems = DB::table($tableNameForSelect)->get(); 
            $html .=            "<div class=\"col-md-4 text-center\">";
            $html .=                "<div class=\"choiceItemDrinkWithSelect\" id=\"choiceItemDrinkWithSelect" .$comboDrink->id ."\">";
            $html .=                    "<img src=\"\\images\\" .$comboDrink->gallery ."\" style=\"width:60%\">";                          
            $html .=                    "<div style=\"padding-top:10px; font-size:20px;\">";
            $html .=                        "<span class=\"choiceItemDrinkName\" id=\"choiceItemDrinkName" .$comboDrink->id ."\">" .$comboDrink->name ."</span>";
            $html .=                        "<select name=\"comboDrink\" class=\"comboDrink\" id=\"comboDrink" .$comboDrink->id ."\" style=\"height: 37px; padding: 4px 10px; margin: 0px 10px\">";
            $html .=                            "<option value = \"0\" selected disable>Choose the flavor</option>";
                                                foreach ($listItems as $listItem) {
            $html .=                                "<option value=" .$listItem->id .">" .$listItem->name ."</option>";
                                                }
            $html .=                        "</select>";
            $html .=                    "</div>"; 
            $html .=                "</div>";
            $html .=                "<div class=\"selectedDiv\">";
            $html .=                    "<h3 class=\"drinkSelected\" id=\"drinkSelected" .$comboDrink->id ."\"></h3>";
            $html .=                "</div>";
            $html .=            "</div>";
                            } else {
            $html .=            "<div class=\"col-md-4 text-center\">";
            $html .=                "<div class=\"choiceItemDrink\" id=\"choiceItemDrink" .$comboDrink->id ."\">";
            $html .=                    "<img src=\"\\images\\" .$comboDrink->gallery ."\" style=\"width:60%\">";
            $html .=                    "<br>";
                                        $displayExtraCharge = ($comboDrink->price > 0) ? (" - Extra Charge: $" .$comboDrink->price) : "";                                        
            $html .=                    "<span class=\"choiceItemDrinkName\" id=\"choiceItemDrinkName" .$comboDrink->id ."\">" .$comboDrink->name .$displayExtraCharge ."</span>";
            $html .=                "</div>";
            $html .=                "<div class=\"selectedDiv\">";
            $html .=                    "<h3 class=\"drinkSelected\" id=\"drinkSelected" .$comboDrink->id ."\"></h3>";
            $html .=                "</div>";
            $html .=            "</div>";
                            }
                        }
        }

        $html .=    "<div class=\"col-md-4 my-auto\">";
        $html .=        "<div class=\"quantityDiv mx-auto\">";
        $html .=            "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$product->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=            "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"1\" id=\"quantity" .$product->id ."\" disabled style=\"margin: 0px 10px\">";
        $html .=            "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$product->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=        "</div>";
        $html .=        "<div>";
        $html .=            "<br>";
        $html .=            "<button type=\"button\" class=\"btn bg-light border addToCart\" disabled id=\"addToCart" .$product->id ."\">Add to Cart</button>";
        $html .=        "</div>";
        $html .=    "</div>";
        $html .= "</div>";

        return $html;

                    /*<div class="row">
                        <div class="text-start">
                            <br>
                            <h3>Choose One Side (or Half/Half)</h3>
                            <br>
                        </div>
                        @foreach($sides as $side)
                            <div class="col-md-4 text-center">
                                <div class="choiceItemSide" id="choiceItemSide{{ $side->id }}">
                                    <img src="\images\{{ $side->gallery }}" style="width:60%">
                                    <br>
                                    <span class="choiceItemSideName" id="choiceItemSideName{{ $side->id }}">{{ $side->name }}</span>
                                </div>
                                <div class="selectedDiv">
                                    <h3 class="sideSelected" id="sideSelected{{ $side->id }}"></h3>
                                    <div class="sideQuantityIncrementDiv mx-auto" id="sideQuantityIncrementDiv{{ $side->id }}" style="display: none;">
                                        <button type="button" class="btn bg-light border rounded-circle sideQuantityMinus" id="sideQuantityMinus{{ $side->id }}"><i class="fas fa-minus"></i></button>
                                        <input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="1" id="sideQuantity{{ $side->id }}" disabled>
                                        <button type="button" class="btn bg-light border rounded-circle sideQuantityPlus" id="sideQuantityPlus{{ $side->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endforeach

                        <div class="text-start">
                            <br>
                            <br>
                            <h3>Choose One Entree</h3>
                            <h5>Chicken</h5>
                        </div>
                        @foreach($chickenEntrees as $chickenEntree)
                            <div class="col-md-4 text-center">
                                <div class="choiceItemEntree" id="choiceItemEntree{{ $chickenEntree->id }}">
                                    <img src="\images\{{ $chickenEntree->gallery }}" style="width:60%">
                                    <br>
                                    <span class="choiceItemEntreeName" id="choiceItemEntreeName{{ $chickenEntree->id }}">{{ $chickenEntree->name }}</span>  
                                </div>
                                <div class="selectedDiv">
                                    <h3 class="entreeSelected" id="entreeSelected{{ $chickenEntree->id }}"></h3>
                                    <div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv{{ $chickenEntree->id }}" style="display: none;">
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus{{ $chickenEntree->id }}"><i class="fas fa-minus"></i></button>
                                        <input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity{{ $chickenEntree->id }}" disabled>
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus{{ $chickenEntree->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endforeach

                        <div class="text-start">
                            <br>
                            <h5>Beef</h5>
                        </div>
                        @foreach($beefEntrees as $beefEntree)
                            <div class="col-md-4 text-center">
                                <div class="choiceItemEntree" id="choiceItemEntree{{ $beefEntree->id }}">
                                    <img src="\images\{{ $beefEntree->gallery }}" style="width:60%">
                                    <br>
                                    <span class="choiceItemEntreeName" id="choiceItemEntreeName{{ $beefEntree->id }}">{{ $beefEntree->name }}</span>  
                                </div>
                                <div class="selectedDiv">
                                    <h3 class="entreeSelected" id="entreeSelected{{ $beefEntree->id }}"></h3>
                                    <div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv{{ $beefEntree->id }}" style="display: none;">
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus{{ $beefEntree->id }}"><i class="fas fa-minus"></i></button>
                                        <input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity{{ $beefEntree->id }}" disabled>
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus{{ $beefEntree->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endforeach

                        <div class="text-start">
                            <br>
                            <h5>Shrimp</h5>
                        </div>
                        @foreach($shrimpEntrees as $shrimpEntree)
                            <div class="col-md-4 text-center">
                                <div class="choiceItemEntree" id="choiceItemEntree{{ $shrimpEntree->id }}">
                                    <img src="\images\{{ $shrimpEntree->gallery }}" style="width:60%">
                                    <br>
                                    <span class="choiceItemEntreeName" id="choiceItemEntreeName{{ $shrimpEntree->id }}">{{ $shrimpEntree->name }}</span>  
                                </div>
                                <div class="selectedDiv">
                                    <h3 class="entreeSelected" id="entreeSelected{{ $shrimpEntree->id }}"></h3>
                                    <div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv{{ $shrimpEntree->id }}" style="display: none;">
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus{{ $shrimpEntree->id }}"><i class="fas fa-minus"></i></button>
                                        <input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity{{ $shrimpEntree->id }}" disabled>
                                        <button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus{{ $shrimpEntree->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endforeach

                        <div class="col-md-4 my-auto">
                            <div class="quantityDiv mx-auto">
                                <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus{{ $product->id }}"><i class="fas fa-minus"></i></button>
                                <input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity{{ $product->id }}" disabled>
                                <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus{{ $product->id }}"><i class="fas fa-plus"></i></button>
                            </div>
                            <div>
                                <br>
                                <button type="button" class="btn bg-light border addToCart" id="addToCart{{ $product1->id }}">Add to Cart</button>
                            </div>
                        </div>
                    </div>*/

                    // Kid's Meal small drink
                    /*<h1>Choices for {{ $product->name }} </h1>
                    <div class="text-start">
                        <br>
                        <h3>Choose Flavour of Small Drink</h3>
                        <br>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="choiceItemDrink" id="choiceItemDrink{{ $productFountain->id }}">
                            <img src="\images\{{ $productFountain->gallery }}" style="width:60%">
                            <div style="padding-top:10px; font-size:25px;">
                                <select name="fountains" id="fountains">
                                    @foreach ($fountains as $fountain)
                                        <option value={{ $fountain->id }}>{{ $fountain->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>*/

                    // Old Menu above
                    /*@foreach($products as $product)
                        <div class="eachMenu" id="eachMenu{{ $product->id }}p">
                            <div class="menuItem" id="menuItem{{ $product->id }}p">
                                <span class="menuItemName{{ $product->id }}p">{{ $product->name }}</span>
                                <br>
                                <span class="menuItemPrice">${{ $product->price }}</span>
                                <br>
                                <span class="menuItemDescription">{{ $product->description }}</span>            
                            </div>      
                        </div>
                        <br>
                    @endforeach
                    @foreach($menus as $menu)
                        <div class="eachMenu" id="eachMenu{{ $menu->id }}">
                            <div class="menuItem" id="menuItem{{ $menu->id }}">
                                <span class="menuItemName{{ $menu->id }}">{{ $menu->name }}</span>
                                <br>
                                <span class="menuItemDescription">{{ $menu->description }}</span>            
                            </div>      
                        </div>
                        <br>
                    @endforeach*/	
    }

    function loadSideChoices($sides)
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
    }

    function loadIndividualSideChoices($single, $mainMenuId)
    {
        $sides = DB::table('sides')->get();
        $productSides = DB::table('products')->where('menu_id', $mainMenuId)->where('category', 'Side')->get();

        $html = "";
        $html .= "<h1>Choices for " .$single->name ."</h1>";
        $html .= "<div class=\"row\">";    
                    foreach($sides as $side) {
        $html .=        "<div class=\"col-md-4 text-center\">";
        $html .=            "<div class=\"choiceItemSide\" id=\"choiceItemSide" .$side->id ."\">";
        $html .=                "<img src=\"\\images\\" .$side->gallery ."\" style=\"width:60%\">";
        $html .=                "<br>";
        $html .=                "<span class=\"choiceItemSideName\" id=\"choiceItemSideName" .$side->id ."\">" .$side->name ."</span>";
        $html .=                "<div>";
        $html .=                    "<select name=\"productSides\" id=\"productSides" .$side->id ."\" style=\"padding:5px 10px; font-size:18px;\">";
                                        foreach ($productSides as $productSide) {
        $html .=                            "<option value=" .$productSide->id .">" .$productSide->name ." - $" .$productSide->price ."</option>";
                                        }    
        $html .=                    "</select>";
        $html .=                "</div>";
        $html .=                "<div class=\"quantityDiv mx-auto\">";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$side->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"0\" id=\"quantity" .$side->id ."\" disabled>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$side->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                "</div>";
        $html .=                "<div>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border addToCartForSide\" id=\"addToCartForSide" .$side->id ."\" disabled>Add to Cart</button>";
        $html .=                "</div>";
        $html .=            "</div>";
        $html .=            "<br>";
        $html .=        "</div>";
                    }
        $html .= "</div>";

        return $html;

                    /*<div class="row">    
                        @foreach($sides as $side)
                            <div class="col-md-4 text-center">
                                <div class="choiceItemSide" id="choiceItemSide{{ $side->id }}">
                                    <img src="\images\{{ $side->gallery }}" style="width:60%">
                                    <br>
                                    <span class="choiceItemSideName" id="choiceItemSideName{{ $side->id }}">{{ $side->name }}</span>
                                    <div>
                                        <select name="productSides" id="productSides{{ $side->id }}" style="padding:5px 10px; font-size:18px;">
                                            @foreach ($productSides as $productSide)
                                                <option value={{ $productSide->id }}>{{ $productSide->name }} - ${{ $productSide->price }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="quantityDiv mx-auto">
                                        <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus{{ $side->id }}"><i class="fas fa-minus"></i></button>
                                        <input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity{{ $side->id }}" disabled>
                                        <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus{{ $side->id }}"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn bg-light border addToCartForSingle" id="addToCartForSingle{{ $side->id }}" disabled>Add to Cart</button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        @endforeach
                    </div>*/
    }

    function loadIndividualEntreeChoices($single, $mainMenuId, $category)
    {
        $entrees = DB::table('entrees')->where('category', $category)->get();
        $productEntrees = DB::table('products')->where('menu_id', $mainMenuId)->where('category', $category)->get();

        $html = "";
        $html .= "<h1>Choices for " .$single->name ."</h1>";
        $html .= "<div class=\"row\">";    
                    foreach($entrees as $entree) {
        $html .=        "<div class=\"col-md-4 text-center\">";
        $html .=            "<div class=\"choiceItemEntree\" id=\"choiceItemEntree" .$entree->id ."\">";
        $html .=                "<img src=\"\\images\\" .$entree->gallery ."\" style=\"width:60%\">";
        $html .=                "<br>";
        $html .=                "<span class=\"choiceItemEntreeName\" id=\"choiceItemEntreeName" .$entree->id ."\">" .$entree->name ."</span>";
        $html .=                "<div>";
        $html .=                    "<select name=\"productEntrees\" id=\"productEntrees" .$entree->id ."\" style=\"padding:5px 10px; font-size:18px;\">";
                                        foreach ($productEntrees as $productEntree) {
        $html .=                            "<option value=" .$productEntree->id .">" .$productEntree->name ." - $" .$productEntree->price ."</option>";
                                        }    
        $html .=                    "</select>";
        $html .=                "</div>";
        $html .=                "<div class=\"quantityDiv mx-auto\">";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$entree->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=                    "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"0\" id=\"quantity" .$entree->id ."\" disabled>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$entree->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=                "</div>";
        $html .=                "<div>";
        $html .=                    "<button type=\"button\" class=\"btn bg-light border addToCartForEntree\" id=\"addToCartForEntree" .$entree->id ."\" disabled>Add to Cart</button>";
        $html .=                "</div>";
        $html .=            "</div>";
        $html .=            "<br>";
        $html .=        "</div>";
                    }
        $html .= "</div>";

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
                $product = $items[$key]['item'];
                $quantity = $items[$key]['quantity'];
                $subItems = $items[$key]['subItems'];
                $totalPricePerItem = $items[$key]['totalPricePerItem'];
                $elements = $elements .cartElement($key, $product, $quantity, $subItems, $totalPricePerItem);
            }
        } 
    }

    function cartElement($key, $product, $quantity, $subItems, $totalPricePerItem)
    {   // $key is serialNumber, using serialNumber instead of productId is the example like User can order many Regular Platters with different Sides and Entrees. But they are the same productId.
        $orderSummary = retrieveSummary($subItems);
        $extraCharge = retrieveExtraCharge($subItems);
        //$totalPrice = $product->price + (double)($extraCharge);
        $totalPriceDisplay = "";
        if ($extraCharge > 0) {
            $totalPriceDisplay = "$" .number_format($product->price, 2, '.', ',') ." + $" .number_format($extraCharge, 2, '.', ',') ." = $" .number_format($totalPricePerItem, 2, '.', ',');
        } else {
            $totalPriceDisplay = "$" .number_format($product->price, 2, '.', ',');
        }
        
        // Handle image for Individaul Side/Entree and Drink
        $image = $product->gallery;
        if ($image == "") {
            $image = retrieveImageFromSubItmes($subItems);
        }

        $element = "
            <form action=\"/cart\" method=\"get\" class=\"cart-items\">
                <div class=\"border rounded\">
                    <div class=\"row bg-white\">
                        <div class=\"col-md-3\">
                            <img src=\"\images\\" .$image . "\" style=\"width: 100%\">
                                      
                        </div>
                        <div class=\"col-md-6\">
                            <h5 class=\"pt-2\">" .$product->name ." <small> (" .$product->description .")</small> </h5>
                            <h5><small style=\"color:red\">" .$orderSummary ."</small> </h5>
                            <h5 class=\"pt-1\">" .$totalPriceDisplay ."</h5>
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

    function retrieveSummary($subItems) {
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

    function retrieveExtraCharge($subItems) {
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

    function retrieveImageFromSubItmes($subItems) {
        // This case for Individual Side/Entree, it should just have one subItem in $subItems
            //$category = $subItems[$key]['category'];  --> if this is Side
            //$quantity = $subItems[$key]['quantity'];
            //$item = $subItems[$key]['item'];          --> Then, this will be the record from sides table

        $image = "";

        if (($subItems == null) || count($subItems) == 0) {
            return $image;
        }

        $keys = array_keys($subItems);
        foreach ($keys as $key) {
            $item = $subItems[$key]['item'];
            $image = $item->gallery;
        }

        return $image;
    }

    function priceDetailDivElement()
    {
        $priceDetail = retrievePriceDetail();
        $element = "
            <div class=\"py-1\">
                <h5>Price Detail</h5>
            </div>
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

    function loadQuantityIncrementDivElelemt()
    {
        $html = "";
        $html .=    "<div class=\"quantityDiv mx-auto\">";
        $html .=        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityMinus\" id=\"quantityMinus" .$product->id ."\"><i class=\"fas fa-minus\"></i></button>";
        $html .=        "<input type=\"text\" class=\"form-control w-25 d-inline text-center quantity\" value=\"1\" id=\"quantity" .$product->id ."\" disabled>";
        $html .=        "<button type=\"button\" class=\"btn bg-light border rounded-circle quantityPlus\" id=\"quantityPlus" .$product->id ."\"><i class=\"fas fa-plus\"></i></button>";
        $html .=    "</div>";

        return $html;
    }
?>