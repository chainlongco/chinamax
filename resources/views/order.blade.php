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
                            <h3>Choose One Side</h3>
                            <br>
                        </div>
                        @foreach($sides as $side)
                            <div class="col-md-4 text-center">
                                <div class="choiceItemSide" id="choiceItemSide{{ $side->id }}">
                                    <img src="\images\{{ $side->gallery }}" style="width:60%">
                                    <br>
                                    <span class="choiceItemSideName" id="choiceItemSideName{{ $side->id }}">{{ $side->name }}</span>  
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
                            </div>
                        @endforeach

                        <div class="col-md-4 my-auto">
                            <div class="quantityDiv mx-auto">
                                <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus"><i class="fas fa-minus"></i></button>
                                <input type="text" class="form-control w-25 d-inline text-center" value="0" id="quantity" disabled>
                                <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus"><i class="fas fa-plus"></i></button>
                            </div>
                            <div>
                                <br>
                                <button type="button" class="btn bg-light border addToCart" disabled id="addToCart">Add to Cart</button>
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
                addNewItemToCart(productId, quantity, null);
            });    
            <!-- Appetizers End -->

            <!-- Side Start -->
            $(document).on('mouseover', '.choiceItemSide', function(e){
                e.preventDefault();
                var sideId = retrieveId("choiceItemSide", this.id);
                $("#choiceItemSideName" + sideId).css("text-decoration","underline");
            });
            $(document).on('mouseout', '.choiceItemSide', function(e){
                e.preventDefault();
                var sideId = retrieveId("choiceItemSide", this.id)
                $("#choiceItemSideName" + sideId).css("text-decoration","none");
            });
            <!-- Side End -->

            <!-- Side Start -->
            $(document).on('mouseover', '.choiceItemEntree', function(e){
                e.preventDefault();
                var sideId = retrieveId("choiceItemEntree", this.id);
                $("#choiceItemEntreeName" + sideId).css("text-decoration","underline");
            });
            $(document).on('mouseout', '.choiceItemEntree', function(e){
                e.preventDefault();
                var sideId = retrieveId("choiceItemEntree", this.id)
                $("#choiceItemEntreeName" + sideId).css("text-decoration","none");
            });
            <!-- Side End -->


            //$("#eachMenu1").trigger('click');
        });

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
    </script>
@endsection