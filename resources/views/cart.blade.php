@extends('layouts.master')
@section('title', 'My Cart')
@section('content')

<?php
    use App\Shared\Cart;
    use App\Shared\Utility;
?>

<div id="mycart">
    <div class="container-fluid">
        <div class="row px-5">
            <div class="col-md-7">
                <div class="shopping-cart py-4">
                    <div class="row">
                        <div class="col-md-5">
                            <?php
                                $title = "My Cart";
                                if (Session::has('cart')) {
                                    $orderId = Session::get('cart')->orderId;
                                    if ($orderId != null) {
                                        $title = "My Cart (From Order History)";
                                    }
                                }
                            ?>
                            <h4 id="cartTitle">{{ $title }}</h4>
                        </div>
                        <div class="col-md-7 text-center">
                            <button style="width: 45%" type="button" class="btn btn-primary addMoreItems">Add More Items</button>
                        </div>
                    </div>
                    <hr>
                    <div id="orderlist">
                        <?php
                            $utility = new Utility();
                            $utility->orderListDivElement();             
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="py-4">
                    <div class="py-1">
                        <h5>Special Requests</h5>
                    </div>
                    <hr>
                    <div class="row" style="position: relative">
                        <div class="col-md-9">
                            <?php
                                $note = "";
                                if (Session::has('cart')){
                                    $cart = new Cart(Session::get('cart'));
                                    $note = $cart->note;
                                }
                            ?>
                            <textarea id="ordernote" rows="3" placeholder="Add Note..." style="width:100%;">{{ $note }}</textarea>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center" style="position: absolute; bottom: 8px;">
                            <button type="button" class="btn btn-primary" id="updateNote">Update Note</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-3">
                    <div id="pricedetail">
                        <?php
                            $utility = new Utility();
                            $utility->priceDetailDivElement();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<div class="modal" id="editModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div id="editBodyFooter">

                <!-- Here will load modal-body and modal-footer -->

            </div>    
            <!-- <div class="modal-body" id="editBody">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary updateCart" disabled id="updateCart">Update</button>
                <button type="button" class="btn btn-danger cancelModal" data-bs-dismiss="modal">Cancel</button>
            </div> -->
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        // ********** Same functions in order.blade.php start **********
        // ***** For combo --Side start *****
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
            //var sideMaxQuantity = $("#sideMaxQuantity").val();
            //choiceSelection = new ChoiceSelection("side", "sideSelected", "choiceItemSide", sideId, 0, sideMaxQuantity);
            //checkSelectedSideItem(sideId, $, choiceSelection, enableAddToCartButtonForCombos);
            checkSelectedSideItem(sideId, $, enableAddToCartButtonForCombos);
        });
        // ***** For combo --Side end *****
        // ***** For combo --Entree start *****
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
            checkSelectedEntreeItem(entreeId, $, enableAddToCartButtonForCombos);
        });
        // ***** For combo --Entree end *****
        // ***** For combo --Drink start *****
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
        // ***** For combo --Drink end *****
        // ********** Same functions in order.blade.php end **********

        function saveNoteToSession(){
            var note = $('#ordernote').val();
            //alert(note);
            $.ajax({
                type: 'GET',
                url: '/cart-note',
                data: {'note':note},
                success: function(response) {
                    //console.log(response.note);
                }
            });
            
        }

        $(document).on('click', '.addMoreItems', function(e){ 
            e.preventDefault();

            const base_path = '{{ url('/') }}\/';
            window.location.href = base_path + 'menu';
        });

        $(document).on('click', '#updateNote', function(e){
            saveNoteToSession();
        });

        //$('#ordernote').focusout(function() {
        //    saveNoteToSession();
        //})

        $(document).on('click', '#emptycart', function(e){
            if (confirm('Are you sure to empty your cart?')) { 
                $.ajax({
                    type: 'GET',
                    url: '/empty-cart',
                    data: {},
                    success: function(response) {
                        $('#cartTitle').html('My Cart')
                        $('#customerLogin').html(response.customerDropdown)
                        $('#ordernote').val("");
                        var html = loadPriceDetailElements(response.priceDetail);
                        $('#pricedetail').html(html);
                        var html = loadCartCountElements(response.priceDetail['totalQuantity']);
                        $('#cartCount').html(html);
                        var html = loadOrderListElements(response.items);
                        $('#orderlist').html(html);
                        var html = loadCheckoutMenuElement(response.priceDetail['totalQuantity']);
                        $('#checkoutMenu').html(html);
                        const base_path = '{{ url('/') }}\/';
                        window.location.href = base_path + 'cart';
                    }
                });
            }
        });

        //$('.quantityPlus').on('click', function(e){  This will not work after ajax call, so use this line below
        $(document).on('click','.quantityPlusForCart', function(e){
            e.preventDefault();
            var serialNumber = retrieveSerialNumberForCartButtons("quantityPlusForCart", this.id);
            var productId = retrieveProductIdForCartButtons("quantityPlusForCart", this.id);
            var quantityElementId = "#quantityForCart" + serialNumber + "AND" + productId;
            var quantity = $(quantityElementId).val();
            quantity = Number(quantity) + 1;
            $(quantityElementId).val(quantity);
            fetchCartAndPriceDetail(serialNumber, quantity);
        });

        //$('.quantityMinus').on('click', function(e){  This will not work after ajax call, so use this line below
        $(document).on('click', '.quantityMinusForCart', function(e){           
            e.preventDefault();
            var serialNumber = retrieveSerialNumberForCartButtons("quantityMinusForCart", this.id);
            var productId = retrieveProductIdForCartButtons("quantityMinusForCart", this.id);
            var quantityElementId = "#quantityForCart" + serialNumber + "AND" + productId;
            var quantity = $(quantityElementId).val();
            quantity = Number(quantity) - 1;
            if (quantity == 0) {
                if (confirm('Are you sure to remove this item?')) {   
                    $(quantityElementId).val(quantity);
                    fetchAllThree(serialNumber, quantity);
                } else {
                    $(quantityElementId).val(Number(quantity)+1);
                }
            } else {
                $(quantityElementId).val(quantity);
                fetchCartAndPriceDetail(serialNumber, quantity);
            }
        });

        //$('.remove').on('click', function(e){   This will not work after ajax call, so use this line below
        $(document).on('click', '.remove', function(e){          
            e.preventDefault();
            if (confirm('Are you sure to remove this item?')) {
                var serialNumber = retrieveSerialNumberForCartButtons("remove", this.id);
                fetchAllThree(serialNumber, 0);
            }
        });

        $(document).on('click', '.edit', function(e){
            e.preventDefault();
            /* To Edit the existing order:
                1. Create an AJAX call here.
                2. Create a Route in web.php: Route::get('/order-edit', [OrderController::class, 'orderEditForPopup']);
                3. Create the function for the Route in OrderController.php: public function orderEditForPopup(Request $request) {
                4. Create a function to handle the response data to build Modal popup: like loadEditModalForAppetizers in common.js
                5. The Modal popup is in cart.blade.php: id="editBodyFooter"
                ------------------------------------------------------------
                After Modal popup:
                1. Create action handler in cart.blade.php:  $(document).on('click', '.updateCart', function(e){
                2. This action handler will call a function which will have an AJAX call: function updateCart(serialNumber, productId, quantity, subItems) {
                3. Create a Route in web.php: Route::get('/order-updated', [OrderController::class, 'orderUpdated']);
                4. Create the function for the Route in ProductController.php: public function orderUpdated(Request $request)
            */         
            var serialNumber = retrieveSerialNumberForCartButtons('edit', this.id);
            /*const base_path = '{{ url('/') }}\/';
            window.location.href = base_path + 'order/' + serialNumber;*/
            $.ajax({
                type: 'GET',
                url: '/order-edit',
                data: {'serialNumber':serialNumber},
                success: function(response) {
                    var html = "";
                    if (response.product['menu_id'] == 1) {
                        $(".modal-dialog").css("max-width", "25vw");
                        html = loadEditModalForAppetizers(response.serialNumber, response.product, response.quantity);
                    }

                    if (response.product['menu_id'] == 2) {
                        $(".modal-dialog").css("max-width", "25vw");
                        if (response.drink['tablename'] == "") {    // For Water and Bottle Water
                            html = loadEditModalForDrinksWithoutSelectBox(response.serialNumber, response.product, response.quantity, response.drink, response.selectDrinks);
                        } else {
                            html = loadEditModalForDrinksWithSelectDrinksOrSelectSizes(response.serialNumber, response.product, response.quantity, response.drink, response.selectDrinks, response.selectDrink, response.sizeProducts);        
                        }
                    } 
                    
                    if (response.product['menu_id'] == 4) {
                        $(".modal-dialog").css("max-width", "25vw");
                        html = loadEditModalForSingleSideEntree(response.serialNumber, response.product, response.quantity, response.productSidesOrEntrees, response.sideOrEntree);
                    }
                    
                    if (response.product['menu_id'] == 3) {
                            $(".modal-dialog").css("max-width", "75vw");
                            // scrollable is set at chinamax.css -- .modal-body
                            html = loadEditModalForCombo(response.serialNumber, response.product, response.quantity, response.sides, response.chickenEntrees, response.beefEntrees, response.shrimpEntrees, response.combo, response.comboDrinks, response.fountains);
                    }

                    //} else {
                        // Do not remember why I need this else. So, I commented out
                        //html = loadEditModal(response.serialNumber, response.product, response.quantity, response.subitems, response.totalPricePerProductItem);
                    //}
                    
                    $("#editBodyFooter").html(html);
                    $("#editModal").show();

                    if (response.product['menu_id'] == 3) {
                        $.each(response.subItems, function(key, value) {
                            category = value['category'];
                            quantity = value['quantity'];
                            item = value['item'];
                            
                            if (category == "Side") { 
                                $("#choiceItemSide" + item['id']).trigger('click');  
                            }
                            if (category == "Entree") {
                                $("#choiceItemEntree" + item['id']).trigger('click');
                            }
                            if (category == "Drink") {
                                if (value.hasOwnProperty('selectDrink')) {
                                    var selectDrink = value['selectDrink'];
                                    $("#comboDrink" + item['id']).val(selectDrink['id']);
                                    $("#comboDrink" + item['id']).trigger('change');
                                } else {
                                    $("#choiceItemDrink" + item['id']).trigger('click');
                                }
                            }
                        });
                    }
                }
            });
        });

        $(document).on('click', '.btn-close', function(e){
            $("#editBodyFooter").html("");
            $('#editModal').hide();
        });

        $(document).on('click', '.cancelModal', function(e){
            $("#editBodyFooter").html("");
            $('#editModal').hide();
        });

        $(document).on('click','.quantityPlusForUpdate', function(e){
            e.preventDefault();
            var productId = retrieveId("quantityPlusForUpdate", this.id);
            var quantityElementId = "#quantityForUpdate" + productId;
            var quantity = $(quantityElementId).val();
            quantity = Number(quantity) + 1;
            $(quantityElementId).val(quantity);
        });

        $(document).on('click', '.quantityMinusForUpdate', function(e){
            e.preventDefault();
            var productId = retrieveId("quantityMinusForUpdate", this.id);
            var quantityElementId = "#quantityForUpdate" + productId;
            var quantity = $(quantityElementId).val();

            quantity = Number(quantity) - 1;
            if (quantity < 0) {
                $(quantityElementId).val(0);
            } else {
                $(quantityElementId).val(quantity);
            }
        });

        $(document).on('click', '.updateCart', function(e){
            e.preventDefault();
            // Base is for Appetizers -- Only display image, product name and price.
            var serialNumber = retrieveSerialNumberForCartButtons("updateCart", this.id);
            var productId = retrieveProductIdForCartButtons("updateCart", this.id);
            var quantity = $("#quantityForUpdate" + productId).val();
            if ($("#drinkId").val() != undefined) { // This is for DrinkOnly
                var drinkId = $("#drinkId").val();
                var subItems = [];
                if ($("#selectDrink" + drinkId).val() != undefined) {
                    var selectBoxId = $("#selectDrink" + drinkId).val();
                    var drinkArray = {'category':'DrinkOnly', 'id':drinkId, 'quantity':quantity, 'selectBoxId':selectBoxId};
                    subItems.push(drinkArray);
                    subItems = JSON.stringify(subItems);    // We need to convert to JSON format when pass data from javascript to PHP.
                } else {
                    var drinkArray = {'category':'DrinkOnly', 'id':drinkId, 'quantity':quantity, 'selectBoxId':null};
                    subItems.push(drinkArray);
                    subItems = JSON.stringify(subItems);    // We need to convert to JSON format when pass data from javascript to PHP.
                }
                if ($("#productDrinks" + drinkId).val() != undefined) {
                    productId = $("#productDrinks" + drinkId).val();    // productId can be changed selecting different size
                }
            }
            if ($("#sideId").val() != undefined) { // This is for Individual Side
                var sideId = $("#sideId").val();
                productId = $("#productSidesOrEntrees" + sideId).val(); // productId can be changed selecting different size
                var subItems = [];
                var sideOrEntreeArray = {'category':'Side', 'id':sideId, 'quantity':quantity};
                subItems.push(sideOrEntreeArray);
                subItems = JSON.stringify(subItems);    // We need to convert to JSON format when pass data from javascript to PHP.
            }
            if ($("#entreeId").val() != undefined) { // This is for Individual Entree
                var entreeId = $("#entreeId").val();
                productId = $("#productSidesOrEntrees" + entreeId).val();   // productId can be changed selecting different size
                var subItems = [];
                var sideOrEntreeArray = {'category':'Entree', 'id':entreeId, 'quantity':quantity};
                subItems.push(sideOrEntreeArray);
                subItems = JSON.stringify(subItems);    // We need to convert to JSON format when pass data from javascript to PHP.
            }
            if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {    // This if for Combo
                // retrieveSubItemsForCombo method is under choiceitem.js -- This return JSON format. Therefore, we need to convert back to array. 
                // We need to convert to JSON format when pass data from javascript to PHP.
                var subItems = (retrieveSubItemsForCombo($));
            }
            updateCart(serialNumber, productId, quantity, subItems);
        });

        function updateCart(serialNumber, productId, quantity, subItems) {
            $.ajax({
                type:'GET',
                url:'/order-updated',
                data:{'serialNumber':serialNumber, 'productId':productId, 'quantity':quantity, 'subItems':subItems},
                datatype: 'JSON',
                contentType: "application/json; charset=utf-8",
                success: function(response) {
                    if (response.status == 0){
                        alert(response.message);
                        //var addToCartElementId = "#addToCart" + productId;
                        //$(addToCartElementId).prop('disabled', false);
                        //$(addToCartElementId).css("color","black");
                        //var quantityElementId = "#quantity" + productId;
                        //$(quantityElementId).val(1);
                    } else {
                        //$('#cartCount').html(response);
                        //const base_path = '{{ url('/') }}\/';
                        //window.location.href = base_path + 'cart';
                        // After move all js code from order.blade.php to ChoiceItem.js, the base_path becomes NaN
                        //window.location.href = 'cart';
                        var html = loadPriceDetailElements(response.priceDetail);
                        $('#pricedetail').html(html);
                        var html = loadCartCountElements(response.priceDetail['totalQuantity']);
                        $('#cartCount').html(html);
                        var html = loadOrderListElements(response.items);
                        $('#orderlist').html(html);
                        var html = loadCheckoutMenuElement(response.priceDetail['totalQuantity']);
                        $('#checkoutMenu').html(html);
                        $(".btn-close").trigger('click');
                    }    
                }
            });
        }

        function fetchCartAndPriceDetail(serialNumber, quantity)
        {
            $.ajax({
                type: 'GET',
                url: '/cart-quantity',
                data: {'serialNumber':serialNumber, 'quantity': quantity},
                success: function(response) {
                    //console.log(response.products);      
                    //console.log(response.price);
                    var html = loadPriceDetailElements(response.priceDetail);
                    $('#pricedetail').html(html);
                    var html = loadCartCountElements(response.priceDetail['totalQuantity']);
                    $('#cartCount').html(html);
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
                    var html = loadPriceDetailElements(response.priceDetail);
                    $('#pricedetail').html(html);
                    var html = loadCartCountElements(response.priceDetail['totalQuantity']);
                    $('#cartCount').html(html);
                    var html = loadOrderListElements(response.items);
                    $('#orderlist').html(html);
                    var html = loadCheckoutMenuElement(response.priceDetail['totalQuantity']);
                    $('#checkoutMenu').html(html);
                }
            });
        }

        $(document).on('click', '#checkout', function(e){
            /*$.ajax({
                type: 'GET',
                url: '/checkout',
                data: {},
                success: function(response) {
                    
                }
            });*/

            const base_path = '{{ url('/') }}\/';
            window.location.href = base_path + 'checkout';
        });  
    });

</script>


@endsection