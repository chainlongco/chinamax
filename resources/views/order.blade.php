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
                    @foreach($products as $product)
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
                    @endforeach
                </div>    
            </div>
            <div class="col-md-9 text-center ">

                <!--<h1>Choices</h1>-->
                <div class="orderChoices">
                    
                    <h1>Choices</h1>
                    <div class="row">
                        <div class="text-start">
                            <br>
                            <h3>Choose One Side (or Half and Half)</h3>
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
                                </div>
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
                                </div>
                                <br>
                            </div>
                        @endforeach

                        <div class="col-md-4 my-auto">
                            <div class="quantityDiv mx-auto">
                                <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus{{ $product->id }}"><i class="fas fa-minus"></i></button>
                                <input type="text" class="form-control w-25 d-inline text-center" value="1" id="quantity{{ $product->id }}" disabled>
                                <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus{{ $product->id }}"><i class="fas fa-plus"></i></button>
                            </div>
                            <div>
                                <br>
                                <button type="button" class="btn bg-light border addToCart" disabled id="addToCart{{ $product->id }}">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
    <br>

    <script>
        $(document).ready(function(){
            <!-- Menu Start -->
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
                retrieveChoices(menuId);
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
                    /*if (confirm('Are you sure to remove this item?')) {   
                        $(quantityElementId).val(quantity);
                        $(addToCartElementId).prop('disabled', true);
                        $(addToCartElementId).css("color","gray");
                    } else {
                        $(quantityElementId).val(Number(quantity)+1);
                    }*/
                } else if (quantity < 0) {
                    $(quantityElementId).val(0);
                } else {
                    $(quantityElementId).val(quantity);
                    $(addToCartElementId).prop('disabled', false);
                }
            });

            $(document).on('click', '.addToCart', function(e){
                var productId = retrieveId("addToCart", this.id);
                var quantityElementId = "#quantity" + productId;
                var quantity = $(quantityElementId).val();
                //alert("button clicked: " + this.id + " Quantity: " + quantity);
                var addToCartElementId = "#addToCart" + productId;
                $(addToCartElementId).prop('disabled', true);
                $(addToCartElementId).css("color","orange");
                $(quantityElementId).val(0);
                addNewItemToCart(productId, quantity, new Array());
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
            <!-- Entree End -->


            //$("#eachMenu1").trigger('click');
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
        function addNewItemToCart(productId, quantity, subItem) {
            $.ajax({
                type:'GET',
                url:'/order-added',
                data:{'productId':productId, 'quantity':quantity, 'subItem':subItem},
                success: function(response) {
                    $('#cartCount').html(response);
                }
            });
        }
        <!-- Appetizer End -->

        <!-- Side Start -->
        function checkSelectedSideItem(sideId) {
            //$(".choiceItemSide").css("border","3px solid lightgray");
            //$("#choiceItemSide" + sideId).css("border","5px solid red");
            //$("#sideSelected" + sideId).text("One Selected");
            if ($("#sideSelected" + sideId).text() == "One Selected") {
                $("#sideSelected" + sideId).text("");
                $("#choiceItemSide" + sideId).css("border","3px solid lightgray");
            } else if ($("#sideSelected" + sideId).text() == "") {
                if (findOneSelectedSideAndChangeToHalf()) {
                    $("#sideSelected" + sideId).text("Half Selected");
                    $("#choiceItemSide" + sideId).css("border","5px solid red");
                    disableRestOfSideChoices();
                } else {
                    $("#sideSelected" + sideId).text("One Selected");
                    $("#choiceItemSide" + sideId).css("border","5px solid red");
                }
            } else if ($("#sideSelected" + sideId).text() == "Half Selected") {
                $("#sideSelected" + sideId).text("");
                $("#choiceItemSide" + sideId).css("border","3px solid lightgray");
                changeFromHalfToOneSelectedSide();
                enableAllSideChoices();
            }
        }

        function findOneSelectedSideAndChangeToHalf() {
            var isOneSelected = false;
            var sideElements = $(".choiceItemSide").toArray();
            sideElements.forEach(function(sideElement) {
                var sideId = retrieveId("choiceItemSide", sideElement.id);
                if ($("#sideSelected" + sideId).text() == "One Selected") {
                    $("#sideSelected" + sideId).text("Half Selected");
                    //alert("inside");
                    isOneSelected = true;
                }
                //alert("inside but not one");
            });
            //alert("outside");
            return isOneSelected;
        }

        function changeFromHalfToOneSelectedSide() {
            var sideElements = $(".choiceItemSide").toArray()
            sideElements.forEach(function(sideElement) {
                var sideId = retrieveId("choiceItemSide", sideElement.id);
                if ($("#sideSelected" + sideId).text() == "Half Selected") {
                    $("#sideSelected" + sideId).text("One Selected");
                }
            });
        }

        function disableRestOfSideChoices() {
            var sideElements = $(".choiceItemSide").toArray()
            sideElements.forEach(function(sideElement) {
                var sideId = retrieveId("choiceItemSide", sideElement.id);
                if ($("#sideSelected" + sideId).text() != "Half Selected") {
                    $("#choiceItemSide" + sideId).prop('disabled', true);
                    $("#choiceItemSide" + sideId).css('background-color', 'lightgray');
                }
            });
        }

        function enableAllSideChoices() {
            var sideElements = $(".choiceItemSide").toArray()
            sideElements.forEach(function(sideElement) {
                var sideId = retrieveId("choiceItemSide", sideElement.id);
                $("#choiceItemSide" + sideId).prop('disabled', false);
                $("#choiceItemSide" + sideId).css('background-color', 'white');
            });
        }
        <!-- Side End -->


        <!-- Entree Start -->
        function checkSelectedEntreeItem(entreeId) {
            //$(".choiceItemEntree").css("border","3px solid lightgray");
            //$("#choiceItemEntree" + entreeId).css("border","5px solid red");
            //$("#entreeSelected" + entreeId).text("One Selected");
            if ($("#entreeSelected" + entreeId).text() == "One Selected") {
                $("#entreeSelected" + entreeId).text("");
                $("#choiceItemEntree" + entreeId).css("border","3px solid lightgray");
                enableAllEntreeChoices();
            } else if ($("#entreeSelected" + entreeId).text() == "") {
                $("#entreeSelected" + entreeId).text("One Selected");
                $("#choiceItemEntree" + entreeId).css("border","5px solid red");
                disableRestOfEntreeChoices();
            }
        }

        function enableAllEntreeChoices() {
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
        }
        <!-- Entree End -->

    </script>
@endsection