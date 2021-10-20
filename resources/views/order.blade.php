@extends('layouts.master')
@section('title', 'Order')
@section('content')

<?php
    require_once(public_path() ."/shared/component.php");
?>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 text-center">
                <div id="orderMenu">
                    <h1>Menu</h1>
                    <?php
                        $keys = array_keys($level1Arrays);
                    ?>
                    @foreach($keys as $key)
                        <div class="eachMenuWithProducts" id="eachMenuWithProducts{{ $level1Arrays[$key]['menu']->id }}">
                            <div class="menuItem" id="menuItem{{ $level1Arrays[$key]['menu']->id }}">
                                <span class="menuItemName{{ $level1Arrays[$key]['menu']->id }}">{{ $level1Arrays[$key]['menu']->name }}</span>
                                <!--<br>-->
                                <p class="menuItemDescription">{{ $level1Arrays[$key]['menu']->description }}</p>
                                @foreach($level1Arrays[$key]['products'] as $product)
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
                    @endforeach
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
                </div>    
            </div>
            <div class="col-md-9 text-center ">
                <div class="orderChoices">
                    
                </div>
            </div>
        </div>
    </div>
    <br>

    <script>
        $(document).ready(function(){
            <!-- Menu Start -->
            $(document).on('mouseover', '.eachMenuWithProducts', function(e){
                e.preventDefault();
                var menuId = retrieveId("eachMenuWithProducts", this.id);
                $(".menuItemName" + menuId).css("text-decoration","underline");
            });
            $(document).on('mouseout', '.eachMenuWithProducts', function(e){
                e.preventDefault();
                var menuId = retrieveId("eachMenuWithProducts", this.id)
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
                retrieveChoices(menuId);
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
                retrieveChoices(productId + "p");
            });
            <!-- Menu End-->

            <!-- Appetizers Start -->    
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

                // ToDo *********
                // this for Combos products -- ToDo: needs to modify for other products
                if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
                    sideMaxQuantity = $("#sideMaxQuantity").val();
                    entreeMaxQuantity = $("#entreeMaxQuantity").val();
                    enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity);
                }

            });

            $(document).on('click', '.quantityMinus', function(e){
                e.preventDefault();
                var productId = retrieveId("quantityMinus", this.id);
                var quantityElementId = "#quantity" + productId;
                var quantity = $(quantityElementId).val();
                var addToCartElementId = "#addToCart" + productId;
                quantity = Number(quantity) - 1;
                if (quantity == 0) {
                    $(quantityElementId).val(quantity);
                    $(addToCartElementId).prop('disabled', true);
                    $(addToCartElementId).css("color","gray");
                } else if (quantity < 0) {
                    $(quantityElementId).val(0);
                } else {
                    $(quantityElementId).val(quantity);
                    $(addToCartElementId).prop('disabled', false);
                }
            });

            // Need to go into the input box to change the value. Otherwise, it will not trigger this change event
            $(document).on('click', ".quantity", function(){
                alert("go");
            });

            $(document).on('click', '.addToCart', function(e){
                var productId = retrieveId("addToCart", this.id);
                var quantityElementId = "#quantity" + productId;
                var quantity = $(quantityElementId).val();
                var addToCartElementId = "#addToCart" + productId;
                $(addToCartElementId).prop('disabled', true);
                $(addToCartElementId).css("color","orange");
                //$(quantityElementId).val(0);
                var subItems = retrieveSubItems();
                addNewItemToCart(productId, quantity, subItems);
            });    
            <!-- Appetizers End -->

            <!-- Side Start -->
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
                checkSelectedSideItem(sideId);
            });
            $(document).on('click','.sideQuantityPlus', function(e){
                e.preventDefault();
                var sideId = retrieveId("sideQuantityPlus", this.id);
                sideMaxQuantity = $("#sideMaxQuantity").val();
                choiceSelection = new ChoiceSelection("side", "sideQuantity", "choiceItemSide", sideId, +1, sideMaxQuantity);
                choiceSelection.showSelected();

                entreeMaxQuantity = $("#entreeMaxQuantity").val();
                enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity);
            });

            $(document).on('click', '.sideQuantityMinus', function(e){       
                e.preventDefault();
                var sideId = retrieveId("sideQuantityMinus", this.id);
                sideMaxQuantity = $("#sideMaxQuantity").val();
                choiceSelection = new ChoiceSelection("side", "sideQuantity", "choiceItemSide", sideId, -1, sideMaxQuantity);
                choiceSelection.showSelected();

                entreeMaxQuantity = $("#entreeMaxQuantity").val();
                enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity);
            });
            <!-- Side End -->

            <!-- Entree Start -->
            $(document).on('mouseover', '.choiceItemEntree', function(e){
                e.preventDefault();
                var entreeId = retrieveId("choiceItemEntree", this.id);
                if ($("#choiceItemEntree" + entreeId).prop("disabled") != true) {
                    $("#choiceItemEntreeName" + entreeId).css("text-decoration","underline");
                }
            });
            $(document).on('mouseout', '.choiceItemEntree', function(e){
                e.preventDefault();
                var entreeId = retrieveId("choiceItemEntree", this.id)
                $("#choiceItemEntreeName" + entreeId).css("text-decoration","none");
            });
            $(document).on('click', '.choiceItemEntree', function(e){
                e.preventDefault();
                var entreeId = retrieveId("choiceItemEntree", this.id);
                checkSelectedEntreeItem(entreeId);
            });
            $(document).on('click','.entreeQuantityPlus', function(e){
                e.preventDefault();
                var entreeId = retrieveId("entreeQuantityPlus", this.id);
                entreeMaxQuantity = $("#entreeMaxQuantity").val();
                choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", entreeId, +1, entreeMaxQuantity);
                choiceSelection.showSelected();

                sideMaxQuantity = $("#sideMaxQuantity").val();
                enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity);
            });

            $(document).on('click', '.entreeQuantityMinus', function(e){       
                e.preventDefault();
                var entreeId = retrieveId("entreeQuantityMinus", this.id);
                entreeMaxQuantity = $("#entreeMaxQuantity").val();
                choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", entreeId, -1, entreeMaxQuantity);
                choiceSelection.showSelected();

                sideMaxQuantity = $("#sideMaxQuantity").val();
                enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity);
            });
            <!-- Entree End -->


            //$("#eachMenu1").trigger('click');
            //$("#eachMenu12p").trigger('click');
            //$("#eachMenu15p").trigger('click');
            //$("#eachMenu13p").trigger('click');
        });


        <!-- Menu Start -->
        function retrieveChoices(menuId) {
            $.ajax({
                type:'GET',
                url:'/order-choices',
                data:{'menuId':menuId},
                success: function(response) {
                    $('.orderChoices').html(response);
                }
            });
        }
        <!-- Menu End -->

        <!-- Appetizer Start -->
        function addNewItemToCart(productId, quantity, subItems) {
            $.ajax({
                type:'GET',
                url:'/order-added',
                data:{'productId':productId, 'quantity':quantity, 'subItems':subItems},
                datatype: 'JSON',
                contentType: "application/json; charset=utf-8",
                success: function(response) {
                    if (response.status == 0){
                        alert(response.message);
                        var addToCartElementId = "#addToCart" + productId;
                        $(addToCartElementId).prop('disabled', false);
                        $(addToCartElementId).css("color","black");
                        var quantityElementId = "#quantity" + productId;
                        $(quantityElementId).val(1);
                    } else {
                        $('#cartCount').html(response);
                        //const base_path = '{{ url('/') }}\/';
                        //window.location.href = base_path + 'cart';
                    }    
                }
            });
        }
        <!-- Appetizer End -->

        <!-- Side Start -->
        function checkSelectedSideItem(sideId) {
            sideMaxQuantity = $("#sideMaxQuantity").val();
            if (sideMaxQuantity == 1) { // Using sideSelected element to display Half/One Selected
                choiceSelection = new ChoiceSelection("side", "sideSelected", "choiceItemSide", sideId, 0, sideMaxQuantity);
                choiceSelection.showSelected();
            } else {    // Using sideQuantity element to display the number of sides selected
                choiceSelection = new ChoiceSelection("side", "sideQuantity", "choiceItemSide", sideId, 0, sideMaxQuantity);
                choiceSelection.showSelected();
            }
            entreeMaxQuantity = $("#entreeMaxQuantity").val();
            enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity);
        }
        <!-- Side End -->


        <!-- Entree Start -->
        function checkSelectedEntreeItem(entreeId) {
            entreeMaxQuantity = $("#entreeMaxQuantity").val();
            if (entreeMaxQuantity == 1) {   // Using entreeSelected to dispaly One Selected
                choiceSelection = new ChoiceSelection("entree", "entreeSelected", "choiceItemEntree", entreeId, 0, entreeMaxQuantity);
                choiceSelection.showSelected();
            } else {    // Using entreeQuantity to display the number of entrees selected
                choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", entreeId, 0, entreeMaxQuantity);
                choiceSelection.showSelected();
            }
            sideMaxQuantity = $("#sideMaxQuantity").val();
            enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity);
        }

        /*function enableAllEntreeChoices() {
            var entreeElements = $(".choiceItemEntree").toArray()
            entreeElements.forEach(function(entreeElement) {
                var entreeId = retrieveId("choiceItemEntree", entreeElement.id);
                $("#choiceItemEntree" + entreeId).prop('disabled', false);
                $("#choiceItemEntree" + entreeId).css('background-color', 'white');
            });
        }

        function disableRestOfEntreeChoices() {
            var entreeElements = $(".choiceItemEntree").toArray()
            entreeElements.forEach(function(entreeElement) {
                var entreeId = retrieveId("choiceItemEntree", entreeElement.id);
                if ($("#entreeSelected" + entreeId).text() != "One Selected") {
                    $("#choiceItemEntree" + entreeId).prop('disabled', true);
                    $("#choiceItemEntree" + entreeId).css('background-color', 'lightgray');
                }
            });
        }*/
        <!-- Entree End -->

        <!-- SubItem Start -->
        function retrieveSubItems() {
            var subItems = [];

            // For side
            var sideElements = $(".choiceItemSide").toArray()
            sideElements.forEach(function(sideElement) {
                var sideId = retrieveId("choiceItemSide", sideElement.id);
                var quantityValue = Number($("#sideQuantity" + sideId).val());
                if ($("#sideSelected" + sideId).text() == "Half Selected") {
                    sideArray = {'category':'Side', 'id':sideId, 'quantity':0.5};
                    subItems.push(sideArray);
                } else if ($("#sideSelected" + sideId).text() == "One Selected") {
                    sideArray = {'category':'Side', 'id':sideId, 'quantity':1};
                    subItems.push(sideArray);
                } else if (quantityValue != 0) {
                    sideArray = {'category':'Side', 'id':sideId, 'quantity':quantityValue};
                    subItems.push(sideArray);
                }
            });

            // For entree
            var entreeElements = $(".choiceItemEntree").toArray()
            entreeElements.forEach(function(entreeElement) {
                var entreeId = retrieveId("choiceItemEntree", entreeElement.id);
                var quantityValue = Number($("#entreeQuantity" + entreeId).val());
                if ($("#entreeSelected" + entreeId).text() == "One Selected") {
                    entreeArray = {'category':'Entree', 'id':entreeId, 'quantity':1};
                    subItems.push(entreeArray);
                } else if (quantityValue != 0) {
                    entreeArray = {'category':'Entree', 'id':entreeId, 'quantity':quantityValue};
                    subItems.push(entreeArray);
                }
            });
            return JSON.stringify(subItems);
        }    
        <!-- SubItem End -->

    </script>
@endsection