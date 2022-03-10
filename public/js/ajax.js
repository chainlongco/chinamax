const APP = (() => {
    var userData = null;
    const myURL = "http://stackoverflow.com";
    const getData = ($) => {
        $.ajax({
            type: "GET",
            url: myURL,
            success: obj.handleSuccess,
            error: obj.handleError,
        });
    };
    const handleError = () => {
        console.log("ERROR");
    };
    const handleSuccess = (data) => {
        userData = data;
        render(data);
        console.log(userData);
    };
    const render = (data) => {
        return "<div>" + data + "</div>";
    };
    const obj = {
        getData,
        handleError,
        handleSuccess,
        render,
    };
    return obj;
})();

module.exports = APP;
  
  
  