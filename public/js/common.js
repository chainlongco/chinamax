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
        subItem = value['subItem'];
        var html = '';
        html = orderListElement(key, product, quantity, subItem);
        $('#orderlist').append(html);
    });
}

function orderListElement(key, product, quantity, subItem)
{
    var html = '';
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
    html += '                       <button type="submit" class="btn btn-warning">Edit</button>';
    html += '                       <button type="button" class="btn btn-danger mx-2 remove" id="remove' + key + "AND" + product['id'] + '">Remove</button>';
    html += '                   </div>';
    html += '               </div>'
    html += '               <div class="col-md-3">';
    html += '                   <div class="py-5">';
    html += '                       <button type="button" class="btn bg-light border rounded-circle quantityMinus" id="quantityMinus' + key + "AND" + product['id'] + '"><i class="fas fa-minus"></i></button>';
    html += '                       <input type="text" class="form-control w-25 d-inline text-center" value="' + quantity + '" id="quantity' + key + "AND" + product['id'] + '" disabled>';
    html += '                       <button type="button" class="btn bg-light border rounded-circle quantityPlus" id="quantityPlus' + key + "AND" + product['id'] + '"><i class="fas fa-plus"></i></button>';
    html += '                   </div>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </form>';
    return html;
}


