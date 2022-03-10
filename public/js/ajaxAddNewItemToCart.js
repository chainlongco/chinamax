const ajaxAddNewItemToCart = (() => {
    const addURL = '/order-added';
    const addNewItemToCart = (productId, quantity, subItems, $) => {
        $.ajax({
            type:'GET',
            url:addURL,
            data:{'productId':productId, 'quantity':quantity, 'subItems':subItems},
            contentType: "application/json; charset=utf-8",
            success: obj.handleSuccess,
            error: obj.handleError,
        });
    };
    const handleError = () => {
        console.log("ERROR");
    };
    const handleSuccess = (response) => {
        render(response);
        console.log("Success to add new item to cart");
    };
    const render = (response) => {
        if (response.status == 0){
            alert(response.message);
        } else {
            //$('#cartCount').html(response);
            document.getElementById("cartCount").innerHTML = response;
            //const base_path = '{{ url('/') }}\/';
            //window.location.href = base_path + 'cart';
            // After move all js code from order.blade.php to ChoiceItem.js, the base_path becomes NaN
            window.location.href = 'cart';
        }
    };
    const obj = {
        addNewItemToCart,
        handleError,
        handleSuccess,
        render,
    };
    return obj;
})();

/*function addNewItemToCart(productId, quantity, subItems) {
    $.ajax({
        type:'GET',
        url:'/order-added',
        data:{'productId':productId, 'quantity':quantity, 'subItems':subItems},
        datatype: 'JSON',
        contentType: "application/json; charset=utf-8",
        success: function(response) {
            if (response.status == 0){
                alert(response.message);
            } else {
                $('#cartCount').html(response);
                //const base_path = '{{ url('/') }}\/';
                //window.location.href = base_path + 'cart';
                // After move all js code from order.blade.php to ChoiceItem.js, the base_path becomes NaN
                window.location.href = 'cart';
            }    
        }
    });
}*/

if (typeof module !== 'undefined'){
    module.exports = {
        ajaxAddNewItemToCart,
    }
};