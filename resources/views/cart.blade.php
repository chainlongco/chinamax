@extends('layouts.master')
@section('title', 'My Cart')
@section('content')

<?php
    require_once(public_path() ."/shared/component.php");
?>

<div id="mycart">
    <div class="container-fluid">
        <div class="row px-5">
            <div class="col-md-7">
                <div class="shopping-cart py-4">
                    <h5>My Cart</h5>
                    <hr>
                    <div id="orderlist">
                        <?php
                            orderListDivElement();             
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="price-detail py-4">
                    <div id="pricedetail">
                        <?php 
                            //priceDetaiDivElement();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        //$('.quantityPlus').on('click', function(e){  This will not work after ajax call, so use this line below
        $(document).on('click','.quantityPlus', function(e){
            e.preventDefault();
            var productId = retrieveId("quantityPlus", this.id);
            var quantityElementId = "#quantity" + productId;
            var quantity = $(quantityElementId).val();
            quantity = Number(quantity) + 1;
            $(quantityElementId).val(quantity);

            // reload cart and price detail
            //fetchPriceDetail(productId, quantity);
            //setTimeout(fetchCartCount, 600, productId, quantity);  // Needs to delay to execute to wait for Session quantity to be set
            fetchCartAndPriceDetail(productId, quantity);
        });

        //$('.quantityMinus').on('click', function(e){  This will not work after ajax call, so use this line below
        $(document).on('click', '.quantityMinus', function(e){           
            e.preventDefault();
            var productId = retrieveId("quantityMinus", this.id);
            var quantityElementId = "#quantity" + productId;
            var quantity = $(quantityElementId).val();
            quantity = Number(quantity) - 1;
            if (quantity == 0) {
                if (confirm('Are you sure to remove this item?')) {   
                    $(quantityElementId).val(quantity);
                   
                    // reload cart, price detail and list
                    //fetchOrderListForRemove(productId);
                    //fetchPriceDetail(productId, quantity);
                    //setTimeout(fetchCartCount, 600, productId, quantity);  // Needs to delay to execute to wait for Session quantity to be set
                    fetchAllThree(productId, quantity);
                } else {
                    $(quantityElementId).val(Number(quantity)+1);
                }
            } else {
                $(quantityElementId).val(quantity);

                // reload cart and price detail
                //fetchPriceDetail(productId, quantity);
                //setTimeout(fetchCartCount, 600, productId, quantity);  // Needs to delay to execute to wait for Session quantity to be set
                fetchCartAndPriceDetail(productId, quantity);
            }
        });

        //$('.remove').on('click', function(e){   This will not work after ajax call, so use this line below
        $(document).on('click', '.remove', function(e){          
            e.preventDefault();
            if (confirm('Are you sure to remove this item?')) {
                var productId = retrieveId("remove", this.id);

                // reload cart, price detail and list
                //fetchOrderListForRemove(productId);
                //fetchPriceDetail(productId, 0);
                //setTimeout(fetchCartCount, 600, productId, 0);  // Needs to delay to execute to wait for Session quantity to be set
                fetchAllThree(productId, 0);
            }
        });

        
        $('.quantity').change(function(){
            alert("go");
        });

        function fetchCartAndPriceDetail(productId, quantity)
        {
            $.ajax({
                type: 'GET',
                url: '/cart-data',
                data: {'id': productId, 'quantity': quantity},
                success: function(response) {
                    //console.log(response.products);      
                    //console.log(response.price);
                    loadPriceDetailElements(response.price);
                    loadCartCountElements(response.price);
                }
            });
        }

        function fetchAllThree(productId, quantity)
        {
            $.ajax({
                type: 'GET',
                url: '/cart-data',
                data: {'id': productId, 'quantity': quantity},
                success: function(response) {
                    console.log(response.products);      
                    console.log(response.price);
                    loadPriceDetailElements(response.price);
                    loadCartCountElements(response.price);
                    loadOrderListElements(response.products);
                }
            });
        }

        function loadPriceDetailElements(priceDetail)
        {   
            $('#pricedetail').html("");
            var html = '<h5>Price Detail</h5>';
            html += '<hr>';
            html += '<div class="row px-5">';
            html += '    <div class="col-md-6 text-start">';
            html += '       <h5>Price (' + priceDetail['items'] + ' items)</h5>';
            html += '       <h5>Tax</h5>';
            html += '       <hr>';
            html += '       <h3>Order Total</h3>';
            html += '   </div>';
            html += '   <div class="col-md-6 text-end">';
            html += '       <h5>$' + priceDetail['subtotal'] + '</h5>';
            html += '       <h5>$' + priceDetail['tax'] + '</h5>';
            html += '       <hr>';
            html += '       <h4>$' + priceDetail['total'] + '</h4>';
            html += '   </div>';
            html += '</div>';
            $('#pricedetail').append(html);
        }

        function loadCartCountElements(priceDetail)
        {
            $('#cartCount').html("");
            var html = '<span id="cart_count" class="text-warning bg-light">' + priceDetail['items'] + '</span>';
            $('#cartCount').append(html);
        }

        function loadOrderListElements(products)
        {
            $('#orderlist').html("");
            var html = '';
            products.forEach(function(product){            
                html += '   <form action="/cart" method="get" class="cart-items">';
                html += '       <div class="border rounded">';
                html += '           <div class="row bg-white">';
                html += '               <div class="col-md-3">';
                html += '                   <img src="\images\\' + product['gallery'] + '" style="width: 100%">';
                html += '               </div>';
                html += '               <div class="col-md-6">';
                html += '                   <h5 class="pt-2">' + product['name'] + '</h5>';
                html += '                   <small class="text-secondary">' + product['description'] + '</small>';
                html += '                   <h5 class="pt-1">$' + product['price'] + '</h5>';
                html += '                   <div class="pb-1">';
                html += '                       <button type="submit" class="btn btn-warning">Save for Later</button>';
                html += '                       <button type="button" class="btn btn-danger mx-2 remove" id="remove' + product['id'] + '">Remove</button>';
                html += '                   </div>';
                html += '               </div>'
                html += '               <div class="col-md-3">';
                html += '                   <div class="py-5">';
                html += '                       <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus' + product['id'] + '"><i class="fas fa-minus"></i></button>';
                html += '                       <input type="text" class="form-control w-25 d-inline" value="' + product['quantity'] + '" id="quantity' +product['id'] + '">';
                html += '                       <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus' + product['id'] + '"><i class="fas fa-plus"></i></button>';
                html += '                   </div>';
                html += '               </div>';
                html += '           </div>';
                html += '       </div>';
                html += '   </form>';
            });
            $('#orderlist').append(html);
        }




        

        
        function fetchPriceDetail(productId, quantity) 
        {
            $.ajax({
                type: 'GET',
                url: '/cart-price',
                data: {'id': productId, 'quantity': quantity},
                success: function(response) {
                    console.log(response);
                    $('#pricedetail').html(response);
                }
            });
        }

        function fetchOrderListForRemove(productId)
        {
            $.ajax({
                type: 'GET',
                url: '/cart-order',
                data: {'id': productId},
                success: function(response) {
                    console.log(response);
                    $('#orderlist').html(response);
                }
            });
        }

        function fetchCartCount(productId, quantity)
        {
            $.ajax({
                type: 'GET',
                url: '/cart-count',
                data: {'id': productId, 'quantity': quantity},
                success: function(response) {
                    console.log(response);      
                    $('#cartCount').html(response);
                }
            });
        }

        
    });

</script>


@endsection