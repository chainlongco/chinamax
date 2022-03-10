const retrieveChoices = require('../../../../public/js/ajaxRetrieveChoices');

describe("ajaxRetrieveChoices Function", () => {
    const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
    beforeEach(() => {
        jest.restoreAllMocks();
    });

    test("Data should load", () => {
        const ajaxSpy = jest.spyOn($, "ajax");
        retrieveChoices.ajaxRetrieveChoices.retrieveChoices($, "13p");
        expect(ajaxSpy).toBeCalledWith({
            type: "GET",
            url: "/order-choices",
            data:{"menuId":"13p", "mainMenuId":undefined},
            success: expect.any(Function),
            error: expect.any(Function),
        });
    });

    test("should handle error", () => {
        const logSpy = jest.spyOn(console, "log");
        retrieveChoices.ajaxRetrieveChoices.handleError();
        expect(logSpy).toBeCalledWith("ERROR");
    });

    test("should handle success", () => {
        document.body.innerHTML = 
            '<div class="orderChoices" id="orderChoices">';

        const response = "<h1>Choices for Regular Platter</h1>";
        const logSpy = jest.spyOn(console, "log");
        retrieveChoices.ajaxRetrieveChoices.handleSuccess(response);
        expect(logSpy).toBeCalledWith("Success to retrieve choices");
    });
});