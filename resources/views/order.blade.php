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
                </div>
            </div>
        </div>
    </div>
    <br>

    <script>
        $(document).ready(function(){
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

            $("#eachMenu1").trigger('click');
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