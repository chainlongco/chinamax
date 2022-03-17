const choiceitem = require('../../../../public/js/choiceitem');

describe('checkSelectedSideItem Function', () => {
    beforeEach(() => {
        jest.restoreAllMocks();
    });

    test('Check Selected Side Item -- sideMaxQuantity = 1', () => {
        const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
        document.body.innerHTML = 
        '<input type="hidden" id="sideMaxQuantity" value="1"/>' +
        '<input type="hidden" id="entreeMaxQuantity" value="1"/>';

        ////choiceSelectionObj = new ChoiceSelection("side", "sideQuantity", "choiceItemSide", sideId, 0, sideMaxQuantity);
        //const choiceSelectionObj = new ChoiceSelection.ChoiceSelection("side", "sideQuantity", "choiceItemSide", 1, 0, 1);
        //const choiceSelectionShowSelected = jest.spyOn(choiceSelectionObj, 'showSelected');
        //const choiceItemShowSelected = jest.spyOn(choiceitem, 'showSelected').mockImplementation(() => Promise.resolve());
        const commonEnableAddToCartButtonForCombos = jest.fn(); //jest.spyOn(common, 'enableAddToCartButtonForCombos');
        const choiceitemShowSelectedFromChoiceItem = jest.spyOn(choiceitem, 'showSelectedFromChoiceItem').mockImplementation(() => {console.log("in the mock??????????????")});

        choiceitem.checkSelectedSideItem(1, $, commonEnableAddToCartButtonForCombos);
        //expect(mockListener).toHaveBeenCalled();
        expect(commonEnableAddToCartButtonForCombos).toHaveBeenCalled();
        expect(choiceitemShowSelectedFromChoiceItem).toHaveBeenCalled();
    });

    test('Check Selected Side Item -- sideMaxQuantity != 1', () => {
        const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
        document.body.innerHTML = 
        '<input type="hidden" id="sideMaxQuantity" value="3"/>' +
        '<input type="hidden" id="entreeMaxQuantity" value="1"/>';

        //choiceSelectionObj = new ChoiceSelection("side", "sideQuantity", "choiceItemSide", sideId, 0, sideMaxQuantity);
        //const choiceSelectionObj = new ChoiceSelection.ChoiceSelection("side", "sideQuantity", "choiceItemSide", 1, 0, 3);
        //const choiceSelectionShowSelected = jest.spyOn(choiceSelectionObj, 'showSelected');
        const commonEnableAddToCartButtonForCombos = jest.fn(); //jest.spyOn(common, 'enableAddToCartButtonForCombos');
        const choiceitemShowSelectedFromChoiceItem = jest.spyOn(choiceitem, 'showSelectedFromChoiceItem').mockImplementation(() => {console.log("in the mock??????????????")});

        choiceitem.checkSelectedSideItem(1, $, commonEnableAddToCartButtonForCombos);
        expect(commonEnableAddToCartButtonForCombos).toHaveBeenCalled();
        expect(choiceitemShowSelectedFromChoiceItem).toHaveBeenCalled();
    });
});

describe('checkSelectedEntreeItem Function', () => {
    beforeEach(() => {
        jest.restoreAllMocks();
    });

    test('Check Selected Entree Item -- entreeMaxQuantity = 1', () => {
        const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
        document.body.innerHTML = 
        '<input type="hidden" id="sideMaxQuantity" value="1"/>' +
        '<input type="hidden" id="entreeMaxQuantity" value="1"/>';

        const commonEnableAddToCartButtonForCombos = jest.fn(); //jest.spyOn(common, 'enableAddToCartButtonForCombos');
        const choiceitemShowSelectedFromChoiceItem = jest.spyOn(choiceitem, 'showSelectedFromChoiceItem').mockImplementation(() => {console.log("in the mock??????????????")});

        choiceitem.checkSelectedEntreeItem(1, $, commonEnableAddToCartButtonForCombos);
        //expect(mockListener).toHaveBeenCalled();
        expect(commonEnableAddToCartButtonForCombos).toHaveBeenCalled();
        expect(choiceitemShowSelectedFromChoiceItem).toHaveBeenCalled();
    });

    test('Check Selected Entree Item -- entreeMaxQuantity != 1', () => {
        const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
        document.body.innerHTML = 
        '<input type="hidden" id="sideMaxQuantity" value="1"/>' +
        '<input type="hidden" id="entreeMaxQuantity" value="3"/>';

        const commonEnableAddToCartButtonForCombos = jest.fn(); //jest.spyOn(common, 'enableAddToCartButtonForCombos');
        const choiceitemShowSelectedFromChoiceItem = jest.spyOn(choiceitem, 'showSelectedFromChoiceItem').mockImplementation(() => {console.log("in the mock??????????????")});

        choiceitem.checkSelectedEntreeItem(1, $, commonEnableAddToCartButtonForCombos);
        expect(commonEnableAddToCartButtonForCombos).toHaveBeenCalled();
        expect(choiceitemShowSelectedFromChoiceItem).toHaveBeenCalled();
    });
});