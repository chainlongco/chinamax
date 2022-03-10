@extends('layouts.master')
@section('title', 'Order')
@section('content')

    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 text-center">
                <div id="orderMenu">
                    <h1>Menu</h1>
                    <div class="eachMenuForCombo" id="eachMenuForCombo{{ $comboArray['menu']->id }}">
                        <div class="menuItem" id="menuItem{{ $comboArray['menu']->id }}">
                            <span class="menuItemName{{ $comboArray['menu']->id }}">{{ $comboArray['menu']->name }}</span>
                            <p class="menuItemDescription">{{ $comboArray['menu']->description }}</p>
                            @foreach($comboArray['products'] as $product)
                                <div class="productItem" id="productItem{{ $product->id }}">
                                    <span class="productItemName{{ $product->id }}">{{ $product->name }}</span>
                                    <br>
                                    <span class="productItemDescription">{{ $product->description }} -- </span> 
                                    <span class="productItemPrice">${{ $product->price }}</span>           
                                </div>
                            @endforeach         
                        </div>      
                    </div>
                    <br>

                    @foreach($menus as $menu)
                        <div class="eachMenu" id="eachMenu{{ $menu->id }}">
                            <div class="menuItem" id="menuItem{{ $menu->id }}">
                                <span class="menuItemName{{ $menu->id }}">{{ $menu->name }}</span>
                                <!--<br>-->
                                <p class="menuItemDescription">{{ $menu->description }}</p>            
                            </div>      
                        </div>
                        <br>
                    @endforeach

                    <div class="eachMenuForSingle" id="eachMenuForSingle{{ $singleArray['menu']->id }}">
                        <div class="menuItem" id="menuItem{{ $singleArray['menu']->id }}">
                            <span class="menuItemName{{ $singleArray['menu']->id }}">{{ $singleArray['menu']->name }}</span>
                            <p class="menuItemDescription">{{ $singleArray['menu']->description }}</p>
                            @foreach($singleArray['singles'] as $single)
                                <div class="singleItem" id="singleItem{{ $single->id }}">
                                    <span class="singleItemName{{ $single->id }}">{{ $single->name }}</span>
                                    <br>
                                    <span class="singleItemDescription">{{ $single->description }}</span>           
                                </div>
                            @endforeach
                        </div>      
                    </div>

                </div>    
            </div>
            <div class="col-md-9 text-center ">
                <div class="orderChoices" id="orderChoices">
                    
                    
                </div>
            </div>
        </div>
    </div>
    <br>



    <script>
        $(document).ready(function(e){
            //$("#productItem13").trigger('click');

            /* Menu Start */
            $(document).on('mouseover', '.eachMenuForCombo', function(e){
                e.preventDefault();

                var menuId = retrieveId("eachMenuForCombo", this.id);
                $(".menuItemName" + menuId).css("text-decoration","underline");
            });
            $(document).on('mouseout', '.eachMenuForCombo', function(e){
                e.preventDefault();
                var menuId = retrieveId("eachMenuForCombo", this.id)
                $(".menuItemName" + menuId).css("text-decoration","none");
            });

            $(document).on('mouseover', '.eachMenuForSingle', function(e){
                e.preventDefault();
                var menuId = retrieveId("eachMenuForSingle", this.id);
                $(".menuItemName" + menuId).css("text-decoration","underline");
            });
            $(document).on('mouseout', '.eachMenuForSingle', function(e){
                e.preventDefault();
                var menuId = retrieveId("eachMenuForSingle", this.id)
                $(".menuItemName" + menuId).css("text-decoration","none");
            });

            $(document).on('mouseover', '.eachMenu', function(e){
                e.preventDefault();
                var menuId = retrieveId("eachMenu", this.id);
                $(".menuItemName" + menuId).css("text-decoration","underline");
            });
            $(document).on('mouseout', '.eachMenu', function(e){
                e.preventDefault();
                var menuId = retrieveId("eachMenu", this.id)
                $(".menuItemName" + menuId).css("text-decoration","none");
            });
            $(document).on('click', '.eachMenu', function(e){
                e.preventDefault();
                var menuId = retrieveId("eachMenu", this.id)
                //$(".menuItem").css("background-color","white");
                //$("#menuItem" + menuId).css("background-color","yellow");
                $(".menuItem").css("border","3px solid lightgray");
                $("#menuItem" + menuId).css("border","5px solid red");
                $(".productItem").css("border","3px solid lightgray");
                $(".singleItem").css("border","3px solid lightgray");
                //retrieveChoices(menuId);
                ajaxRetrieveChoices.retrieveChoices($, menuId);
            });

            $(document).on('mouseover', '.productItem', function(e){
                e.preventDefault();
                var productId = retrieveId("productItem", this.id);
                $(".productItemName" + productId).css("text-decoration","underline");
            });
            $(document).on('mouseout', '.productItem', function(e){
                e.preventDefault();
                var productId = retrieveId("productItem", this.id)
                $(".productItemName" + productId).css("text-decoration","none");
            });
            $(document).on('click', '.productItem', function(e){
                e.preventDefault();
                var productId = retrieveId("productItem", this.id)
                $(".productItem").css("border","3px solid lightgray");
                $("#productItem" + productId).css("border","5px solid red");
                $(".menuItem").css("border","3px solid lightgray");
                $(".singleItem").css("border","3px solid lightgray");
                //retrieveChoices(productId + "p");
                ajaxRetrieveChoices.retrieveChoices($,productId + "p");
            });

            $(document).on('mouseover', '.singleItem', function(e){
                e.preventDefault();
                var singleId = retrieveId("singleItem", this.id);
                $(".singleItemName" + singleId).css("text-decoration","underline");
            });
            $(document).on('mouseout', '.singleItem', function(e){
                e.preventDefault();
                var singleId = retrieveId("singleItem", this.id)
                $(".singleItemName" + singleId).css("text-decoration","none");
            });
            $(document).on('click', '.singleItem', function(e){
                e.preventDefault();
                var singleId = retrieveId("singleItem", this.id)
                $(".singleItem").css("border","3px solid lightgray");
                $("#singleItem" + singleId).css("border","5px solid red");
                $(".menuItem").css("border","3px solid lightgray");
                $(".productItem").css("border","3px solid lightgray");

                // retrieve menu id
                var parentClassName = $(this).parent().attr('class');
                var parentIdName = $(this).parent().attr('id');
                var menuId = retrieveId(parentClassName, parentIdName);
                //retrieveChoices(singleId + "s", menuId);
                ajaxRetrieveChoices.retrieveChoices($, singleId + "s", menuId);
            });
            /* Menu End */

            /* Shared Start */    
            $(document).on('click','.quantityPlus', function(e){
                e.preventDefault();
                var productId = retrieveId("quantityPlus", this.id);
                var quantityElementId = "#quantity" + productId;
                var quantity = $(quantityElementId).val();
                quantity = Number(quantity) + 1;
                $(quantityElementId).val(quantity);
                
                var addToCartElementId = "#addToCart" + productId;
                //document.getElementById("addToCart1").style.color = "red";                
                $(addToCartElementId).prop("disabled", false);
                $(addToCartElementId).css("color","red");

                var addToCartForComboElementId = "#addToCartForCombo" + productId;
                $(addToCartForComboElementId).prop("disabled", false);
                $(addToCartForComboElementId).css("color","red");

                var addToCartForSideElementId = "#addToCartForSide" + productId;
                $(addToCartForSideElementId).prop("disabled", false);
                $(addToCartForSideElementId).css("color","red");

                var addToCartForEntreeElementId = "#addToCartForEntree" + productId;
                $(addToCartForEntreeElementId).prop("disabled", false);
                $(addToCartForEntreeElementId).css("color","red");

                var addToCartForDrinkOnlyElementId = "#addToCartForDrinkOnly" + productId;
                $(addToCartForDrinkOnlyElementId).prop("disabled", false);
                $(addToCartForDrinkOnlyElementId).css("color","red");


                // ToDo *********
                // For Combos products -- ToDo: needs to modify for other products
                if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
                    sideMaxQuantity = $("#sideMaxQuantity").val();
                    entreeMaxQuantity = $("#entreeMaxQuantity").val();
                    drinkMaxQuantity = $("#drinkMaxQuantity").val();
                    enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity, $);
                }

                // For Drink Only 
                if ($(".addToCartForDrinkOnly").text() != "") {
                    var drinkId = retrieveId("quantityPlus", this.id);
                    enableAddToCartButtonForDrinkOnly(drinkId, $);
                }

            });

            $(document).on('click', '.quantityMinus', function(e){
                e.preventDefault();
                var productId = retrieveId("quantityMinus", this.id);
                var quantityElementId = "#quantity" + productId;
                var quantity = $(quantityElementId).val();
                var addToCartElementId = "#addToCart" + productId;
                
                var addToCartForSideElementId = "#addToCartForSide" + productId;
                var addToCartForEntreeElementId = "#addToCartForEntree" + productId;
                var addToCartForDrinkOnlyElementId = "#addToCartForDrinkOnly" + productId;
                quantity = Number(quantity) - 1;
                if (quantity == 0) {
                    $(quantityElementId).val(quantity);   
                    $(addToCartElementId).css("color","gray");
                    $(addToCartElementId).prop('disabled', true);

                    $(addToCartForSideElementId).css("color","gray");
                    $(addToCartForSideElementId).prop('disabled', true);
                    $(addToCartForEntreeElementId).css("color","gray");
                    $(addToCartForEntreeElementId).prop('disabled', true);
                    $(addToCartForDrinkOnlyElementId).css("color","gray");
                    $(addToCartForDrinkOnlyElementId).prop('disabled', true);
                } else if (quantity < 0) {
                    $(quantityElementId).val(0);
                } else {
                    $(quantityElementId).val(quantity);
                    $(addToCartElementId).prop('disabled', false);
                    
                    $(addToCartForSideElementId).prop('disabled', false);
                    $(addToCartForEntreeElementId).prop('disabled', false);
                    $(addToCartForDrinkOnlyElementId).prop('disabled', false);
                }

                // For Combos products -- ToDo: needs to modify for other products
                if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
                    sideMaxQuantity = $("#sideMaxQuantity").val();
                    entreeMaxQuantity = $("#entreeMaxQuantity").val();
                    drinkMaxQuantity = $("#drinkMaxQuantity").val();
                    enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity, $);
                }

                // For Drink Only 
                if ($(".addToCartForDrinkOnly").text() != "") {
                    var drinkId = retrieveId("quantityMinus", this.id);
                    enableAddToCartButtonForDrinkOnly(drinkId, $);
                }
            });

            // Need to go into the input box to change the value. Otherwise, it will not trigger this change event
            $(document).on('click', ".quantity", function(){
                alert("go");
            });
            /* Shared End */


            /* Appetizers Start */
            $(document).on('click', '.addToCart', function(e){  // For Appetizers
                var productId = retrieveId("addToCart", this.id);
                var quantityElementId = "#quantity" + productId;
                var quantity = $(quantityElementId).val();
                var subItems = [];
                //addNewItemToCart(productId, quantity, subItems);
                ajaxAddNewItemToCart.addNewItemToCart(productId, quantity, subItems, $);
            });    
            /* Appetizers End */

            /* Combo Start */
            $(document).on('click', '.addToCartForCombo', function(e){  // For Combos
                var productId = retrieveId("addToCartForCombo", this.id);
                var quantityElementId = "#quantity" + productId;
                var quantity = $(quantityElementId).val();
                var subItems = retrieveSubItemsForCombo($);  // It is converted to JSON format inside retrieveSubItemsForCombo method
                //addNewItemToCart(productId, quantity, subItems);
                ajaxAddNewItemToCart.addNewItemToCart(productId, quantity, subItems, $);
            });    
            /* Combo End */

            /* Single Start */
            $(document).on('click', '.addToCartForSide', function(e){
                e.preventDefault();
                var sideId = retrieveId("addToCartForSide", this.id);
                var quantityElementId = "#quantity" + sideId;
                var quantity = $(quantityElementId).val();
                productId = $("#productSides" + sideId).val();
                var subItems = [];
                var sideArray = {'category':'Side', 'id':sideId, 'quantity':quantity};
                subItems.push(sideArray);
                //addNewItemToCart(productId, quantity, JSON.stringify(subItems));
                ajaxAddNewItemToCart.addNewItemToCart(productId, quantity, JSON.stringify(subItems), $);
            });

            $(document).on('click', '.addToCartForEntree', function(e){
                e.preventDefault();
                var entreeId = retrieveId("addToCartForEntree", this.id);
                var quantityElementId = "#quantity" + entreeId;
                var quantity = $(quantityElementId).val();
                productId = $("#productEntrees" + entreeId).val();
                var subItems = [];
                var entreeArray = {'category':'Entree', 'id':entreeId, 'quantity':quantity};
                subItems.push(entreeArray);
                //addNewItemToCart(productId, quantity, JSON.stringify(subItems));
                ajaxAddNewItemToCart.addNewItemToCart(productId, quantity, JSON.stringify(subItems), $);
            });
            /* Single End */

            /* Side Start */
            $(document).on('mouseover', '.choiceItemSide', function(e){
                e.preventDefault();

                // from https://stackoverflow.com/questions/9421208/how-to-compare-colors-in-javascript
                /*var compareHex = (hex) => {
                    var hexString = document.createElement('div')
                    hexString.style.backgroundColor = `${hex}`
                    return hexString.style.backgroundColor
                }
                var current_color = $("#choiceItemSide" + sideId).css("background-color");
                if (current_color !== compareHex('#d3d3d3')) {*/

                var sideId = retrieveId("choiceItemSide", this.id);
                if ($("#choiceItemSide" + sideId).prop("disabled") != true) {
                    $("#choiceItemSideName" + sideId).css("text-decoration","underline");
                }
            });
            $(document).on('mouseout', '.choiceItemSide', function(e){
                e.preventDefault();
                var sideId = retrieveId("choiceItemSide", this.id)
                $("#choiceItemSideName" + sideId).css("text-decoration","none");
            });
            $(document).on('click', '.choiceItemSide', function(e){
                e.preventDefault();
                var sideId = retrieveId("choiceItemSide", this.id);
                checkSelectedSideItem(sideId, $);
            });
            $(document).on('click','.sideQuantityPlus', function(e){
                e.preventDefault();
                if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
                    var sideId = retrieveId("sideQuantityPlus", this.id);
                    sideMaxQuantity = $("#sideMaxQuantity").val();
                    choiceSelection = new ChoiceSelection("side", "sideQuantity", "choiceItemSide", sideId, +1, sideMaxQuantity);
                    choiceSelection.showSelected($);
                    entreeMaxQuantity = $("#entreeMaxQuantity").val();
                    drinkMaxQuantity = $("#drinkMaxQuantity").val();
                    enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity, $);
                }
            });

            $(document).on('click', '.sideQuantityMinus', function(e){       
                e.preventDefault();
                if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
                    var sideId = retrieveId("sideQuantityMinus", this.id);
                    sideMaxQuantity = $("#sideMaxQuantity").val();
                    choiceSelection = new ChoiceSelection("side", "sideQuantity", "choiceItemSide", sideId, -1, sideMaxQuantity);
                    choiceSelection.showSelected($);
                    entreeMaxQuantity = $("#entreeMaxQuantity").val();
                    drinkMaxQuantity = $("#drinkMaxQuantity").val();
                    enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity, $);
                }
            });
            /* Side End */

            /* Entree Start */
            $(document).on('mouseover', '.choiceItemEntree', function(e){
                e.preventDefault();
                var entreeId = retrieveId("choiceItemEntree", this.id);
                if ($("#choiceItemEntree" + entreeId).prop("disabled") != true) {
                    $("#choiceItemEntreeName" + entreeId).css("text-decoration","underline");
                }
            });
            $(document).on('mouseout', '.choiceItemEntree', function(e){
                e.preventDefault();
                var entreeId = retrieveId("choiceItemEntree", this.id);
                $("#choiceItemEntreeName" + entreeId).css("text-decoration","none");
            });
            $(document).on('click', '.choiceItemEntree', function(e){
                e.preventDefault();
                var entreeId = retrieveId("choiceItemEntree", this.id);
                checkSelectedEntreeItem(entreeId);
            });
            $(document).on('click','.entreeQuantityPlus', function(e){
                e.preventDefault();
                if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
                    var entreeId = retrieveId("entreeQuantityPlus", this.id);
                    entreeMaxQuantity = $("#entreeMaxQuantity").val();
                    choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", entreeId, +1, entreeMaxQuantity);
                    choiceSelection.showSelected($);
                    sideMaxQuantity = $("#sideMaxQuantity").val();
                    drinkMaxQuantity = $("#drinkMaxQuantity").val();
                    enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity, $);
                }
            });

            $(document).on('click', '.entreeQuantityMinus', function(e){       
                e.preventDefault();
                if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
                    var entreeId = retrieveId("entreeQuantityMinus", this.id);
                    entreeMaxQuantity = $("#entreeMaxQuantity").val();
                    choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", entreeId, -1, entreeMaxQuantity);
                    choiceSelection.showSelected($);
                    sideMaxQuantity = $("#sideMaxQuantity").val();
                    drinkMaxQuantity = $("#drinkMaxQuantity").val();
                    enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity, $);
                }
            });
            /* Entree End */

            /* Drink Start */
            $(document).on('mouseover', '.choiceItemDrink', function(e){
                e.preventDefault();
                var drinkId = retrieveId("choiceItemDrink", this.id);
                if ($("#choiceItemDrink" + drinkId).prop("") != true) {
                    $("#choiceItemDrinkName" + drinkId).css("text-decoration","underline");
                }
            });
            $(document).on('mouseout', '.choiceItemDrink', function(e){
                e.preventDefault();
                var drinkId = retrieveId("choiceItemDrink", this.id)
                $("#choiceItemDrinkName" + drinkId).css("text-decoration","none");
            });
            $(document).on('click', '.choiceItemDrink', function(e){
                e.preventDefault();
                if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
                    var drinkId = retrieveId("choiceItemDrink", this.id);
                    drinkMaxQuantity = $('#drinkMaxQuantity').val();
                    choiceSelection = new ChoiceSelection("drink", "drinkSelected", "choiceItemDrink", drinkId, 0, drinkMaxQuantity);
                    choiceSelection.showSelected($);
                    sideMaxQuantity = $("#sideMaxQuantity").val();
                    entreeMaxQuantity = $("#entreeMaxQuantity").val();
                    drinkMaxQuantity = $("#drinkMaxQuantity").val();
                    enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity, $);
                }
            });
            $(document).on('mouseover', '.choiceItemDrinkWithSelect', function(e){
                e.preventDefault();
                var drinkId = retrieveId("choiceItemDrinkWithSelect", this.id);
                if ($("#choiceItemDrinkWithSelect" + drinkId).prop("disabled") != true) {
                    $("#choiceItemDrinkName" + drinkId).css("text-decoration","underline");
                }
            });
            $(document).on('mouseout', '.choiceItemDrinkWithSelect', function(e){
                e.preventDefault();
                var drinkId = retrieveId("choiceItemDrinkWithSelect", this.id);
                $("#choiceItemDrinkName" + drinkId).css("text-decoration","none");
            });
            $(document).on('change', '.comboDrink', function(e){
                e.preventDefault();
                if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
                    var drinkId = retrieveId("comboDrink", this.id);
                    drinkMaxQuantity = $('#drinkMaxQuantity').val();
                    choiceSelection = new ChoiceSelection("drink", "drinkSelected", "choiceItemDrinkWithSelect", drinkId, 0, drinkMaxQuantity);
                    choiceSelection.showSelected($);
                    sideMaxQuantity = $("#sideMaxQuantity").val();
                    entreeMaxQuantity = $("#entreeMaxQuantity").val();
                    drinkMaxQuantity = $("#drinkMaxQuantity").val();
                    enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity, $);
                }
            });
            /* Drink End */


            /* Drink Only Start */
            $(document).on('click', '.addToCartForDrinkOnly', function(e){
                e.preventDefault();
                var drinkId = retrieveId("addToCartForDrinkOnly", this.id);                
                var quantityElementId = "#quantity" + drinkId;
                var quantity = $(quantityElementId).val();
                var productId = 0;
                if ($("#productId" + drinkId).val() != undefined) {
                    productId = $("#productId" + drinkId).val();  // From hidden input box
                } else {
                    productId = $("#productDrinks" + drinkId).val();    // From List box
                }
                
                var subItems = [];
                if ($("#selectDrink" + drinkId).val() != undefined) {
                    var selectBoxId = $("#selectDrink" + drinkId).val();
                    var drinkArray = {'category':'DrinkOnly', 'id':drinkId, 'quantity':quantity, 'selectBoxId':selectBoxId};
                    subItems.push(drinkArray);
                } else {
                    var drinkArray = {'category':'DrinkOnly', 'id':drinkId, 'quantity':quantity, 'selectBoxId':null};
                    subItems.push(drinkArray);
                }
                //addNewItemToCart(productId, quantity, JSON.stringify(subItems));
                ajaxAddNewItemToCart.addNewItemToCart(productId, quantity, JSON.stringify(subItems), $);
            });
            
            $(document).on('change', '.selectDrink', function(e){
                var drinkId = retrieveId("selectDrink", this.id);
                enableAddToCartButtonForDrinkOnly(drinkId, $);
            });
            /* Drink Only End */


            //$("#eachMenu1").trigger('click');
            //$("#productItem12").trigger('click');
            //$("#productItem15").trigger('click');
            //$("#productItem13").trigger('click');
            //$("#productItem16").trigger('click');
            //$("#singleItem2").trigger('click');

            $("#productItem13").trigger('click');
        });       
    </script>
@endsection