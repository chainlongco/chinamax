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
                    <div class="row">
                        <div class="col-md-2">
                            <h5>My Cart</h5>
                        </div>
                        <div class="col-md-10 text-center">
                            <button style="width: 30%" type="button" class="btn btn-primary addMoreItems">Add More Items</button>
                        </div>
                    </div>
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
                            priceDetailDivElement();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(document).on('click', '.addMoreItems', function(e){ 
            e.preventDefault();
            const base_path = '{{ url('/') }}\/';
            window.location.href = base_path + 'order';
        }); 

        //$('.quantityPlus').on('click', function(e){  This will not work after ajax call, so use this line below
        $(document).on('click','.quantityPlus', function(e){
            e.preventDefault();
            var serialNumber = retrieveSerialNumberForCartButtons("quantityPlus", this.id);
            var productId = retrieveProductIdForCartButtons("quantityPlus", this.id);
            var quantityElementId = "#quantity" + serialNumber + "AND" + productId;
            var quantity = $(quantityElementId).val();
            quantity = Number(quantity) + 1;
            $(quantityElementId).val(quantity);
            // reload cart and price detail
            //fetchPriceDetail(productId, quantity);
            //setTimeout(fetchCartCount, 600, productId, quantity);  // Needs to delay to execute to wait for Session quantity to be set
            fetchCartAndPriceDetail(serialNumber, quantity);
        });

        //$('.quantityMinus').on('click', function(e){  This will not work after ajax call, so use this line below
        $(document).on('click', '.quantityMinus', function(e){           
            e.preventDefault();
            var serialNumber = retrieveSerialNumberForCartButtons("quantityMinus", this.id);
            var productId = retrieveProductIdForCartButtons("quantityMinus", this.id);
            var quantityElementId = "#quantity" + serialNumber + "AND" + productId;
            var quantity = $(quantityElementId).val();
            quantity = Number(quantity) - 1;
            if (quantity == 0) {
                if (confirm('Are you sure to remove this item?')) {   
                    $(quantityElementId).val(quantity);
                   
                    // reload cart, price detail and list
                    //fetchOrderListForRemove(productId);
                    //fetchPriceDetail(productId, quantity);
                    //setTimeout(fetchCartCount, 600, productId, quantity);  // Needs to delay to execute to wait for Session quantity to be set
                    fetchAllThree(serialNumber, quantity);
                } else {
                    $(quantityElementId).val(Number(quantity)+1);
                }
            } else {
                $(quantityElementId).val(quantity);

                // reload cart and price detail
                //fetchPriceDetail(productId, quantity);
                //setTimeout(fetchCartCount, 600, productId, quantity);  // Needs to delay to execute to wait for Session quantity to be set
                fetchCartAndPriceDetail(serialNumber, quantity);
            }
        });

        //$('.remove').on('click', function(e){   This will not work after ajax call, so use this line below
        $(document).on('click', '.remove', function(e){          
            e.preventDefault();
            if (confirm('Are you sure to remove this item?')) {
                var serialNumber = retrieveSerialNumberForCartButtons("remove", this.id);

                // reload cart, price detail and list
                //fetchOrderListForRemove(productId);
                //fetchPriceDetail(productId, 0);
                //setTimeout(fetchCartCount, 600, productId, 0);  // Needs to delay to execute to wait for Session quantity to be set
                fetchAllThree(serialNumber, 0);
            }
        });

        function fetchCartAndPriceDetail(serialNumber, quantity)
        {
            $.ajax({
                type: 'GET',
                url: '/cart-quantity',
                data: {'serialNumber':serialNumber, 'quantity': quantity},
                success: function(response) {
                    //console.log(response.products);      
                    //console.log(response.price);
                    loadPriceDetailElements(response.priceDetail);
                    loadCartCountElements(response.priceDetail['totalQuantity']);
                }
            });
        }

        function fetchAllThree(serialNumber, quantity)
        {
            $.ajax({
                type: 'GET',
                url: '/cart-quantity',
                data: {'serialNumber':serialNumber, 'quantity': quantity},
                success: function(response) {
                    //console.log(response.products);      
                    //console.log(response.price);
                    loadPriceDetailElements(response.priceDetail);
                    loadCartCountElements(response.priceDetail['totalQuantity']);
                    loadOrderListElements(response.items);
                }
            });
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