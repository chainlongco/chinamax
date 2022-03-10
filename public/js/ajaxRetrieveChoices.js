const ajaxRetrieveChoices = (() => {
    const choiceURL = '/order-choices';
    const retrieveChoices = ($,  menuId, mainMenuId) => {
        $.ajax({
            type:'GET',
            url:choiceURL,
            data:{'menuId':menuId, 'mainMenuId':mainMenuId},
            success: obj.handleSuccess,
            error: obj.handleError,
        });
    };
    const handleError = () => {
        console.log("ERROR");   // For jest test purpose, we use console.log here
    };
    const handleSuccess = (response) => {
        render(response);
        console.log("Success to retrieve choices");  // For jest test purpose, we use console.log here
    };
    const render = (response) => {
        //$('.orderChoices').html(response);
        document.getElementById("orderChoices").innerHTML = response;   // For jest test purpose, use javascript syntax instead of jquery. Because it says $ is not defined
    };
    const obj = {
        retrieveChoices,
        handleError,
        handleSuccess,
        render,
    };
    return obj;
})();

/*function retrieveChoices(menuId, mainMenuId, $) {
    $.ajax({
        type:'GET',
        url:'/order-choices',
        data:{'menuId':menuId, 'mainMenuId':mainMenuId},
        success: function(response) {
            $('.orderChoices').html(response);
        }
    });
}*/

if (typeof module !== 'undefined'){
    module.exports = {
        ajaxRetrieveChoices,
    }
};