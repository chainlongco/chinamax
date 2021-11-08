function retrieveId(elementClass, elementClassId)
{
    // quantityMinus1 is elementClassId, quantityMinus is elementClass
    var lengthClass = elementClass.length;
    var lengthClassId = elementClassId.length;
    var id = elementClassId.substr(lengthClass, (lengthClassId-lengthClass));
    return id;
}

function retrieveProductIdForCartButtons(elementClass, elementClassId)
{
    // quantityMinus1AND2 -- 1 is the serialNumber, 2 is the productId
    var lengthClass = elementClass.length;
    var lengthClassId = elementClassId.length;
    var serialNumberAndProductId = elementClassId.substr(lengthClass, (lengthClassId-lengthClass)); // retrieve 1AND2
    var posAND = serialNumberAndProductId.indexOf('AND');
    var productId = serialNumberAndProductId.substr((posAND+2+1), (serialNumberAndProductId.length-(posAND+2+1)));
    return productId;
}

function retrieveSerialNumberForCartButtons(elementClass, elementClassId)
{
    // quantityMinus1AND2 -- 1 is the serialNumber, 2 is the productId
    var lengthClass = elementClass.length;
    var lengthClassId = elementClassId.length;
    var serialNumberAndProductId = elementClassId.substr(lengthClass, (lengthClassId-lengthClass)); // retrieve 1AND2
    var posAND = serialNumberAndProductId.indexOf('AND');
    var serialNumber = serialNumberAndProductId.substr(0, posAND);
    return serialNumber;
}

function loadPriceDetailElements(priceDetail)
{   
    $('#pricedetail').html("");
    var html = '<h5>Price Detail</h5>';
    html += '<hr>';
    html += '<div class="row px-5">';
    html += '    <div class="col-md-6 text-start">';
    html += '       <h5>Price (' + priceDetail['totalQuantity'] + ' items)</h5>';
    html += '       <h5>Tax</h5>';
    html += '       <hr>';
    html += '       <h3>Order Total</h3>';
    html += '   </div>';
    html += '   <div class="col-md-6 text-end">';
    html += '       <h5>$' + priceDetail['totalPrice'] + '</h5>';
    html += '       <h5>$' + priceDetail['tax'] + '</h5>';
    html += '       <hr>';
    html += '       <h4>$' + priceDetail['total'] + '</h4>';
    html += '   </div>';
    html += '</div>';
    $('#pricedetail').append(html);
}

function loadCartCountElements(quantity)
{
    $('#cartCount').html("");
    var html = '<span id="cart_count" class="text-warning bg-light">' + quantity + '</span>';
    $('#cartCount').append(html);
}

function loadOrderListElements(items)
{
    $('#orderlist').html("");
    $.each(items, function(key, value) {
        console.log(key, value);
        product = value['item'];
        quantity = value['quantity'];
        subItems = value['subItems'];
        totalPricePerItem = value['totalPricePerItem'];
        var html = '';
        html = orderListElement(key, product, quantity, subItems, totalPricePerItem);
        $('#orderlist').append(html);
    });
}

function orderListElement(key, product, quantity, subItems, totalPricePerItem)
{   // $key is serialNumber, using serialNumber instead of productId is the example like User can order many Regular Platters with different Sides and Entrees. But they are the same productId.
    var orderSummary = retrieveSummary(subItems);
    var extraCharge = retrieveExtraCharge(subItems);
    var totalPriceDisplay = "";
    if (extraCharge > 0) {
        totalPriceDisplay = "$" + product['price'].toFixed(2) + " + $" + extraCharge.toFixed(2) + " = $" + totalPricePerItem.toFixed(2);
    } else {
        totalPriceDisplay = "$" + product['price'].toFixed(2);
    }

    // Handle image for Individaul Side/Entree and Drink
    var image = product['gallery'];
    if (image == "") {
        image = retrieveImageFromSubItmes(subItems);
    }

    var html = '';
    html += '   <form action="/cart" method="get" class="cart-items">';
    html += '       <div class="border rounded">';
    html += '           <div class="row bg-white">';
    html += '               <div class="col-md-3">';
    html += '                   <img src="\images\\' + image + '" style="width: 100%">';
    html += '               </div>';
    html += '               <div class="col-md-6">';
    html += '                   <h5 class="pt-2">' + product['name'] + ' <small> (' + product['description'] + ')</small> </h5>';
    html += '                   <h5><small style="color:red">' + orderSummary + '</small> </h5>';
    html += '                   <h5 class=\"pt-1\">' + totalPriceDisplay + '</h5>';
    html += '                   <div class="pb-1">';
    html += '                       <button type="submit" class="btn btn-warning edit" id="edit' + key + "AND" + product['id'] + '" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>';
    html += '                       <button type="button" class="btn btn-danger mx-2 remove" id="remove' + key + "AND" + product['id'] + '">Remove</button>';
    html += '                   </div>';
    html += '               </div>'
    html += '               <div class="col-md-3">';
    html += '                   <div class="py-5">';
    html += '                       <button type="button" class="btn bg-light border rounded-circle quantityMinusForCart" id="quantityMinusForCart' + key + "AND" + product['id'] + '"><i class="fas fa-minus"></i></button>';
    html += '                       <input type="text" class="form-control w-25 d-inline text-center" value="' + quantity + '" id="quantityForCart' + key + "AND" + product['id'] + '" disabled>';
    html += '                       <button type="button" class="btn bg-light border rounded-circle quantityPlusForCart" id="quantityPlusForCart' + key + "AND" + product['id'] + '"><i class="fas fa-plus"></i></button>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </form>';
    return html;
}

function retrieveSummary(subItems)
{
    var summary = "";
    var side = "";
    var entree = "";
    var drink = "";
    var drinkOnly = "";

    $.each(subItems, function(key, value) {
        console.log(key, value);
        category = value['category'];
        quantity = value['quantity'];
        item = value['item'];
        
        if (quantity == 0.5) {
            quantity = "1/2";
        }
        if (category == "Side") {
            if (subItems.keys().length > 1) {  // This means combo not Individual Side/Entree 
                side = side + item['name'] + "(" + quantity + ") ";
            } else {
                side = side + item['name'] + " ";
            }        
        }
        if (category == "Entree") {
            if (subItems.keys().length > 1) {  // This means combo not Individual Side/Entree 
                entree = entree + item['name'] + "(" + quantity + ") ";
            } else {
                entree = entree + item['name'] + " ";
            }
            
        }
        if (category == "Drink") {
            var selectDrinkSummary = "";
            if (value.hasOwnProperty('selectDrink')) {
                var selectDrink = value['selectDrink'];
                selectDrinkSummary = " - " + selectDrink['name'];
            }
            if (item['price'] > 0) {
                drink = drink + item['name'] + " - extra charge: $" + item['price'].toFixed(2); //+ " (" + quantity + ") ";
            } else {
                drink = drink + item['name'] + selectDrinkSummary; //+ "(" + quantity + ") ";
            }
        }
        if (category == "DrinkOnly") {
            var selectDrinkSummary = "";
            if (value.hasOwnProperty('selectDrink')) {
                 var selectDrink = value['selectDrink'];
                 var selectDrinkSummary = "Flavor: "  + selectDrink['name'];
                 drinkOnly = drinkOnly + selectDrinkSummary;
            }
        }
    });

    if (side != "") {
        summary += "Side: " + side;
    }
    if (entree != "") {
        summary += "Entree: " + entree;
    }
    if (drink != "") {
        summary += "Drink: " + drink;
    }
    if (drinkOnly != "") {
        summary += drinkOnly;
    }

    return summary;
}

function retrieveExtraCharge(subItems)
{
    var extraCharge = 0;

    $.each(subItems, function(key, value) {
        category = value['category'];
        quantity = value['quantity'];
        item = value['item'];
        
        if (category == "Drink") {
            if (item['price'] > 0) {
                extraCharge += item['price'];   // This item is from combodrinks table
            }
        }
    });
    return extraCharge;
}

function retrieveImageFromSubItmes(subItems) {
    // This case for Individual Side/Entree, it should just have one subItem in $subItems
        //category = value['category']; --> if this is Side
        //quantity = value['quantity'];
        //item = value['item'];         --> Then, this will be the record from sides table

    var image = "";

    if ((subItems == null) || (subItems.length == 0)) {
        return image;
    }

    $.each(subItems, function(key, value) {
        item = value['item'];
        image = item['gallery'];
    });
    return image;
}

function enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity) {
    if (($("#sideMaxQuantity").val() == undefined) || ($("#entreeMaxQuantity").val() == undefined)) {
        return;
    }

    var orderQuantity = $(".quantity").val();
    if (orderQuantity == 0) {
        $(".addToCartForCombo").prop('disabled', true);
        $(".addToCartForCombo").css('color', 'gray');
        return;
    }

    // For side
    var totalSideQuantity = retrieveTotalSideQuantity();

    // For entree
    var totalEntreeQuantity = retrieveTotalEntreeQuantity();

    if (drinkMaxQuantity == undefined) {
        if ((totalSideQuantity == sideMaxQuantity) && (totalEntreeQuantity == entreeMaxQuantity)) {
            $(".addToCartForCombo").prop('disabled', false);
            $(".addToCartForCombo").css('color', 'red');
        } else {
            $(".addToCartForCombo").prop('disabled', true);
            $(".addToCartForCombo").css('color', 'gray');
        }
    } else {
        // For Drink
        var totalDrinkQuantity = retrieveTotalDrinkQuantity();

        if ((totalSideQuantity == sideMaxQuantity) && (totalEntreeQuantity == entreeMaxQuantity) && (totalDrinkQuantity == drinkMaxQuantity)) {
            $(".addToCartForCombo").prop('disabled', false);
            $(".addToCartForCombo").css('color', 'red');
        } else {
            $(".addToCartForCombo").prop('disabled', true);
            $(".addToCartForCombo").css('color', 'gray');
        }
    }
}

function retrieveTotalSideQuantity() {
    var totalSideQuantity = 0;
    var sideElements = $(".choiceItemSide").toArray()
    sideElements.forEach(function(sideElement) {
        var sideId = retrieveId("choiceItemSide", sideElement.id);
        var quantityValue = Number($("#sideQuantity" + sideId).val());
        if ($("#sideSelected" + sideId).text() == "Half Selected") {
            totalSideQuantity += 0.5;
        } else if ($("#sideSelected" + sideId).text() == "One Selected") {
            totalSideQuantity += 1;
        } else if (quantityValue != 0) {
            totalSideQuantity += quantityValue;
        }
    });
    return totalSideQuantity;
}

function retrieveTotalEntreeQuantity() {
    var totalEntreeQuantity = 0;
    var entreeElements = $(".choiceItemEntree").toArray()
    entreeElements.forEach(function(entreeElement) {
        var entreeId = retrieveId("choiceItemEntree", entreeElement.id);
        var quantityValue = Number($("#entreeQuantity" + entreeId).val());
        if ($("#entreeSelected" + entreeId).text() == "One Selected") {
            totalEntreeQuantity += 1;
        } else if (quantityValue != 0) {
            totalEntreeQuantity += quantityValue;
        }
    });
    return totalEntreeQuantity;
}

function retrieveTotalDrinkQuantity() {
    var totalDrinkQuantity = 0;
    var drinkElements = $(".choiceItemDrink").toArray()
    drinkElements.forEach(function(drinkElement) {
        var drinkId = retrieveId("choiceItemDrink", drinkElement.id);
        if ($("#drinkSelected" + drinkId).text() == "One Selected") {
            totalDrinkQuantity += 1;
        }
    });
    var drinkWithSelectElements = $(".choiceItemDrinkWithSelect").toArray()
    drinkWithSelectElements.forEach(function(drinkWithSelectElement) {
        var drinkId = retrieveId("choiceItemDrinkWithSelect", drinkWithSelectElement.id);
        if ($("#drinkSelected" + drinkId).text() == "One Selected") {
            totalDrinkQuantity += 1;
        }
    });
    return totalDrinkQuantity;
}

function enableAddToCartButtonForDrinkOnly(drinkId) {
    if ($("#selectDrink" + drinkId).val() == undefined) {
        if ($("#quantity" + drinkId).val() > 0) {
            $("#addToCartForDrinkOnly" + drinkId).prop('disabled', false);
        } else {
            $("#addToCartForDrinkOnly" + drinkId).prop('disabled', true);
        }
    } else {
        if ($("#selectDrink" + drinkId).val() > 0) {
            if ($("#quantity" + drinkId).val() > 0) {
                $("#addToCartForDrinkOnly" + drinkId).prop('disabled', false);
            } else {
                $("#addToCartForDrinkOnly" + drinkId).prop('disabled', true);
            }
        } else {
            $("#addToCartForDrinkOnly" + drinkId).prop('disabled', true);
        }
    }
}
           
function loadEditModalForAppetizers(serialNumber, product, quantity) {
    var html = "";
    html += '<div class="modal-body">';
    html += '   <div class="col-md-12 text-center">';
    html += '       <div class="choiceItem">';
    html += '           <img src="\\images\\' + product['gallery'] + '" style="width:60%">';
    html += '           <br>';
    html += '           <span class="choiceItemName">' + product['name'] + '</span>';
    html += '           <br>';
    html += '           <span class="choiceItemPrice">$' + product['price'].toFixed(2) + '</span>';
    html +=             '<br>';
    html += '           <div class="quantityDiv mx-auto">';
    html += '               <button type="button" class="btn bg-light border rounded-circle quantityMinusForUpdate" id="quantityMinusForUpdate' + product['id'] + '"><i class="fas fa-minus"></i></button>';
    html += '               <input type="text" class="form-control w-25 d-inline text-center quantityForUpdate" value="' + quantity + '" id="quantityForUpdate' + product['id'] + '" disabled>';
    html += '               <button type="button" class="btn bg-light border rounded-circle quantityPlusForUpdate" id="quantityPlusForUpdate' + product['id'] + '"><i class="fas fa-plus"></i></button>';
    html += '           </div>';          
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    html += '<div class="modal-footer">';
    html += '   <button type="button" class="btn btn-primary updateCart" id="updateCart' + serialNumber + 'AND' + product['id'] + '">Update</button>';
    html += '   <button type="button" class="btn btn-danger cancelModal" data-bs-dismiss="modal">Cancel</button>';
    html += '</div>';
    return html;
}

function loadEditModalForDrinksWithoutSelectBox(serialNumber, product, quantity, drink) {
    var html = "";
    html += '<div class="modal-body">';
    html += '   <div class="col-md-12 text-center">';
    html += '       <div class="choiceItem">';
    html += '           <input type="hidden" id="drinkId" value=' + drink['id'] + '>';
    html += '           <img src="\\images\\' + drink['gallery'] + '" style="width:60%">';
    html += '           <br>';
    html += '           <span class="choiceItemName">' + product['name'] + '</span>';
    html += '           <br>';
    html += '           <span class="choiceItemPrice">$' + product['price'].toFixed(2) + '</span>';
    html +=             '<br>';
    html += '           <div class="quantityDiv mx-auto">';
    html += '               <button type="button" class="btn bg-light border rounded-circle quantityMinusForUpdate" id="quantityMinusForUpdate' + product['id'] + '"><i class="fas fa-minus"></i></button>';
    html += '               <input type="text" class="form-control w-25 d-inline text-center quantityForUpdate" value="' + quantity + '" id="quantityForUpdate' + product['id'] + '" disabled>';
    html += '               <button type="button" class="btn bg-light border rounded-circle quantityPlusForUpdate" id="quantityPlusForUpdate' + product['id'] + '"><i class="fas fa-plus"></i></button>';
    html += '           </div>';          
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    html += '<div class="modal-footer">';
    html += '   <button type="button" class="btn btn-primary updateCart" id="updateCart' + serialNumber + 'AND' + product['id'] + '">Update</button>';
    html += '   <button type="button" class="btn btn-danger cancelModal" data-bs-dismiss="modal">Cancel</button>';
    html += '</div>';
    return html;
}

function loadEditModalForDrinksWithSelectDrinksOrSelectSizes(serialNumber, product, quantity, drink, selectDrinks, selectDrink, sizeProducts) {
    var size = 0;
    sizeProducts.forEach(function(sizeProduct) {
        size++;
    });

    var html = "";
    html += '<div class="modal-body">';
    html += '   <div class="col-md-12 text-center">';
    html += '       <div class="choiceItem">';
    html += '           <input type="hidden" id="drinkId" value=' + drink['id'] + '>';
    html += '           <img src="\\images\\' + drink['gallery'] + '" style="width:60%">';
    html += '           <br>';

                        if (size == 1) {
    html += '               <span class="choiceItemDrinkName" id="choiceItemDrinkName' + drink['id'] + '">' + drink['name'] + ' - $' + product['price'].toFixed(2) + '</span>';
                        } else {
    html += '               <span class="choiceItemDrinkName" id="choiceItemDrinkName' + drink['id'] + '">' + drink['name'] + '</span>';
                        }
    
    html += '           <div style="padding-top:10px; font-size:20px;">';
    html += '               <select name="selectDrink" class="selectDrink" id="selectDrink' + drink['id'] + '" style="height: 37px; padding: 0px 10px; ">';
    //html += '                   <option value =' + '0' + ' disable>Choose the flavor</option>';
                                    selectDrinks.forEach(function(subDrink) {
    html += '                       <option value=' + subDrink['id'] + ' ' + (subDrink['id'] == selectDrink['id'] ? "selected" : "") + '>' + subDrink['name'] + '</option>';
                                });
    html += '               </select>';
    html += '           </div>';

                        if (size > 1) {        
    html += '               <div style="padding-top:10px; font-size:20px;">';
    html += '                   <select name="productDrinks" id="productDrinks' + drink['id'] + '" style="height: 37px; padding: 0px 10px; ">';
                                    sizeProducts.forEach(function(sizeProduct) {
    html += '                           <option value=' + sizeProduct['id'] + ' ' + (sizeProduct['id'] == product['id'] ? "selected" : "") + '>' + sizeProduct['name'] + ' - $' + sizeProduct['price'].toFixed(2) + '</option>';
                                    });
    html += '                   </select>';
    html += '               </div>';
                        }        
    
    html += '           <div class="quantityDiv mx-auto">';
    html += '               <button type="button" class="btn bg-light border rounded-circle quantityMinusForUpdate" id="quantityMinusForUpdate' + product['id'] + '"><i class="fas fa-minus"></i></button>';
    html += '               <input type="text" class="form-control w-25 d-inline text-center quantityForUpdate" value="' + quantity + '" id="quantityForUpdate' + product['id'] + '" disabled>';
    html += '               <button type="button" class="btn bg-light border rounded-circle quantityPlusForUpdate" id="quantityPlusForUpdate' + product['id'] + '"><i class="fas fa-plus"></i></button>';
    html += '           </div>';          
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    html += '<div class="modal-footer">';
    html += '   <button type="button" class="btn btn-primary updateCart" id="updateCart' + serialNumber + 'AND' + product['id'] + '">Update</button>';
    html += '   <button type="button" class="btn btn-danger cancelModal" data-bs-dismiss="modal">Cancel</button>';
    html += '</div>';
    return html;
}

function loadEditModalForSingleSideEntree(serialNumber, product, quantity, productSidesOrEntrees, sideOrEntree) {
    html = "";
    html += '<div class="modal-body">';
    html += '   <div class="col-md-12 text-center">';
    html += '       <div class="choiceItem">';
                        if (product['category']=="Side") {
    html += '               <input type="hidden" id="sideId" value=' + sideOrEntree['id'] + '>';
                        } else {
    html += '               <input type="hidden" id="entreeId" value=' + sideOrEntree['id'] + '>';                        
                        }
    html += '           <img src="\\images\\' + sideOrEntree['gallery'] + '" style="width:60%">';
    html += '           <br>';
    html += '           <span class="choiceItemSideOrEntreeName" id="choiceItemSideOrEntreeName' + sideOrEntree['id'] + '">' + sideOrEntree['name'] + '</span>';
    html += '       <div>';
    html += '       <select name="productSidesOrEntrees" id="productSidesOrEntrees' + sideOrEntree['id'] + '" style="padding:5px 10px; font-size:18px;">';
                        productSidesOrEntrees.forEach(function(productSideOrEntree){
    html += '               <option value=' + productSideOrEntree['id'] + ' ' + (productSideOrEntree['id'] == product['id'] ? "selected" : "") + '>' + productSideOrEntree['name'] + ' - $' + productSideOrEntree['price'] + '</option>';
                        });    
    html += '       </select>';
    html += '   </div>';
    html += '   <div class="quantityDiv mx-auto">';
    html += '       <button type="button" class="btn bg-light border rounded-circle quantityMinusForUpdate" id="quantityMinusForUpdate' + product['id'] + '"><i class="fas fa-minus"></i></button>';
    html += '       <input type="text" class="form-control w-25 d-inline text-center quantityForUpdate" value="' + quantity + '" id="quantityForUpdate' + product['id'] + '" disabled>';
    html += '       <button type="button" class="btn bg-light border rounded-circle quantityPlusForUpdate" id="quantityPlusForUpdate' + product['id'] + '"><i class="fas fa-plus"></i></button>';
    html += '   </div>';
    html += '</div>';
    html += '<div class="modal-footer">';
    html += '   <button type="button" class="btn btn-primary updateCart" id="updateCart' + serialNumber + 'AND' + product['id'] + '">Update</button>';
    html += '   <button type="button" class="btn btn-danger cancelModal" data-bs-dismiss="modal">Cancel</button>';
    html += '</div>';

    return html;
}

function loadEditModal(serialNumber, product, quantity, subItems, totalPricePerItem) {
    var html = "";
    html += '<div class="modal-body">';
    html += '   <div class="col-md-12 text-center">';
    html += '       <div class="choiceItem">';
    html += '           <img src="\\images\\' + product['gallery'] + '" style="width:60%">';
    html += '           <br>';
    html += '           <span class="choiceItemName">' + product['name'] + '</span>';
    html += '           <br>';
    html += '           <span class="choiceItemPrice">$' + product['price'].toFixed(2) + '</span>';
    html +=             '<br>';
    html += '           <div class="quantityDiv mx-auto">';
    html += '               <button type="button" class="btn bg-light border rounded-circle quantityMinusForUpdate" id="quantityMinusForUpdate' + product['id'] + '"><i class="fas fa-minus"></i></button>';
    html += '               <input type="text" class="form-control w-25 d-inline text-center quantityForUpdate" value="' + quantity + '" id="quantityForUpdate' + product['id'] + '" disabled>';
    html += '               <button type="button" class="btn bg-light border rounded-circle quantityPlusForUpdate" id="quantityPlusForUpdate' + product['id'] + '"><i class="fas fa-plus"></i></button>';
    html += '           </div>';          
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    html += '<div class="modal-footer">';
    html += '   <button type="button" class="btn btn-primary updateCart" id="updateCart' + serialNumber + 'AND' + product['id'] + '">Update</button>';
    html += '   <button type="button" class="btn btn-danger cancelModal" data-bs-dismiss="modal">Cancel</button>';
    html += '</div>';
    return html;
}