const addNewItemToCart = require('../../../../public/js/ajaxAddNewItemToCart');

describe("ajaxAddNewItemToCart Function", () => {
    const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');

    beforeEach(() => {
        jest.restoreAllMocks();
    });

    test("Data should load", () => {
        var productId = 1;
        var quantity = 1;
        var subItems = [];
        const ajaxSpy = jest.spyOn($, "ajax");
        addNewItemToCart.ajaxAddNewItemToCart.addNewItemToCart(productId, quantity, subItems, $);
        expect(ajaxSpy).toBeCalledWith({
            type:"GET",
            url:"/order-added",
            data:{'productId':productId, 'quantity':quantity, 'subItems':subItems},
            contentType: "application/json; charset=utf-8",
            success: expect.any(Function),
            error: expect.any(Function),
        });
    });

    test("should handle error", () => {
        const logSpy = jest.spyOn(console, "log");
        addNewItemToCart.ajaxAddNewItemToCart.handleError();
        expect(logSpy).toBeCalledWith("ERROR");
    });

    test("should handle success -- status != 0", () => {
        let assignMock = jest.fn();
        delete window.location;
        window.location = { assign: assignMock };

        document.body.innerHTML = 
            '<span id="cartCount"> ';

        const response = "1";
        const logSpy = jest.spyOn(console, "log");
        addNewItemToCart.ajaxAddNewItemToCart.handleSuccess(response);
        expect(logSpy).toBeCalledWith("Success to add new item to cart");

        assignMock.mockClear();
    });

    test("should handle success -- status == 0", () => {
        window.alert = jest.fn();
        document.body.innerHTML = 
            '<span id="cartCount"> ';

        const response = {status: 0, message: test};
        const logSpy = jest.spyOn(console, "log");
        addNewItemToCart.ajaxAddNewItemToCart.handleSuccess(response);
        expect(logSpy).toBeCalledWith("Success to add new item to cart");
    });
});