const {ChoiceSelection} = require('../../../../public/js/ChoiceSelection');

describe('showSelected Function', () => {
    const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
    // constructor(category, elementIdPrefix, divElementIdPrefix, id, quantity, maxQuantity) {
    // if maxQuantity = 1, then
    //  elementIdPrefix is sideSelected or entreeSelected or drinkSelected.
    //  divElementIdPrefix is choiceItemSide or choiceItemEntree or choiceItemDrink

    // if maxQuantity > 2, then
    // elementIdPrefix is sideQuantity or entreeQuantity (this indicates the quantity, sideQuantityIncrementDiv/entreeQuantityIncrementDiv, sideQuantityPlus/entreeQuantityPlus, sideQuantityMinus/entreeQuantityMinus)
    // divElementIdPrefix is choiceItemSide or choiceItemEntree
    
    describe('handleMaxOneSideSelected function', () => {
        test('Show Selected -- quantity=0, maxQuantity=1, the text of sideSelected1 is One Selected', () => {
            document.body.innerHTML =
                '<h3 class="sideSelected" id="sideSelected1">One Selected</h3>' +
                '<h3 class="sideSelected" id="sideSelected2"></h3>' +
                '<h3 class="sideSelected" id="sideSelected3"></h3>' +
                '<div class="choiceItemSide" id="choiceItemSide1">' +
                '<div class="choiceItemSide" id="choiceItemSide2">' +
                '<div class="choiceItemSide" id="choiceItemSide3">';

            const choiceSelection = new ChoiceSelection("side", "sideSelected", "choiceItemSide", 1, 0, 1);
            choiceSelection.showSelected($);
            var text1 = $("#sideSelected1").text();
            expect(text1).toBe("");
            var border1 = $("#choiceItemSide1").css("border");
            expect(border1).toBe("3px solid lightgray");       
        });

        test('Show Selected -- quantity=0, maxQuantity=1, the text of sideSelected1 is empty, the text of sideSelected2 is One Selected', () => {
            document.body.innerHTML =
                '<h3 class="sideSelected" id="sideSelected1"></h3>' +
                '<h3 class="sideSelected" id="sideSelected2">One Selected</h3>' +
                '<h3 class="sideSelected" id="sideSelected3"></h3>' +
                '<div class="choiceItemSide" id="choiceItemSide1">' +
                '<div class="choiceItemSide" id="choiceItemSide2">' +
                '<div class="choiceItemSide" id="choiceItemSide3">';

            const choiceSelection = new ChoiceSelection("side", "sideSelected", "choiceItemSide", 1, 0, 1);
            choiceSelection.showSelected($);
            var text1 = $("#sideSelected1").text();
            expect(text1).toBe("Half Selected");
            var text2 = $("#sideSelected2").text();
            expect(text2).toBe("Half Selected");
            var border1 = $("#choiceItemSide1").css("border");
            expect(border1).toBe("5px solid red");
            var disabled3 = $("#choiceItemSide3").prop("disabled");
            expect(disabled3).toBeTruthy();
            var backgroundColor3 = $("#choiceItemSide3").css("background-color");
            expect(backgroundColor3).toBe("lightgray");
        });
        
        test('Show Selected -- quantity=0, maxQuantity=1, the text of sideSelected1 is empty, sideSelected2, and sideSelected3 are empty too', () => {
            document.body.innerHTML =
                '<h3 class="sideSelected" id="sideSelected1"></h3>' +
                '<h3 class="sideSelected" id="sideSelected2"></h3>' +
                '<h3 class="sideSelected" id="sideSelected3"></h3>' +
                '<div class="choiceItemSide" id="choiceItemSide1">' +
                '<div class="choiceItemSide" id="choiceItemSide2">' +
                '<div class="choiceItemSide" id="choiceItemSide3">';

            const choiceSelection = new ChoiceSelection("side", "sideSelected", "choiceItemSide", 1, 0, 1);
            choiceSelection.showSelected($);
            var text1 = $("#sideSelected1").text();
            expect(text1).toBe("One Selected");
            var border1 = $("#choiceItemSide1").css("border");
            expect(border1).toBe("5px solid red");       
        });

        test('Show Selected -- quantity=0, maxQuantity=1, the text of sideSelected1 is Half Selected, sideSelected2 is Half Selected too, and sideSelected3 are empty', () => {
            document.body.innerHTML =
                '<h3 class="sideSelected" id="sideSelected1">Half Selected</h3>' +
                '<h3 class="sideSelected" id="sideSelected2">Half Selected</h3>' +
                '<h3 class="sideSelected" id="sideSelected3"></h3>' +
                '<div class="choiceItemSide" id="choiceItemSide1">' +
                '<div class="choiceItemSide" id="choiceItemSide2">' +
                '<div class="choiceItemSide" id="choiceItemSide3">';

            const choiceSelection = new ChoiceSelection("side", "sideSelected", "choiceItemSide", 1, 0, 1);
            choiceSelection.showSelected($);
            var text1 = $("#sideSelected1").text();
            expect(text1).toBe("");
            var border1 = $("#choiceItemSide1").css("border");
            expect(border1).toBe("3px solid lightgray");
            var text2 = $("#sideSelected2").text();
            expect(text2).toBe("One Selected");
            
            var disabled1 = $("#choiceItemSide1").prop("disabled");
            expect(disabled1).toBeFalsy();
            var disabled2 = $("#choiceItemSide2").prop("disabled");
            expect(disabled2).toBeFalsy();
            var disabled3 = $("#choiceItemSide3").prop("disabled");
            expect(disabled3).toBeFalsy();

            var backgroundColor1 = $("#choiceItemSide1").css("background-color");
            expect(backgroundColor1).toBe("white");
            var backgroundColor2 = $("#choiceItemSide2").css("background-color");
            expect(backgroundColor2).toBe("white");
            var backgroundColor3 = $("#choiceItemSide3").css("background-color");
            expect(backgroundColor3).toBe("white");
            //$('.' + this.divElementIdPrefix).prop('disabled', false);
            //$('.' + this.divElementIdPrefix).css('background-color', 'white');    
        });
    });

    
    describe('handleMaxOneSideSelected function', () => {
        test('Show Selected -- quantity=0, maxQuantity=1, the text of entreeSelected1 is One Selected', () => {
            document.body.innerHTML =
                '<h3 class="entreeSelected" id="entreeSelected1">One Selected</h3>' +
                '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">';

            const choiceSelection = new ChoiceSelection("entree", "entreeSelected", "choiceItemEntree", 1, 0, 1);
            choiceSelection.showSelected($);
            var text1 = $("#entreeSelected1").text();
            expect(text1).toBe("");
            var border1 = $("#choiceItemEntree1").css("border");
            expect(border1).toBe("3px solid lightgray");       
        });

        test('Show Selected -- quantity=0, maxQuantity=1, the text of entreeSelected1 is empty, but entreeSelected2 is One Selected', () => {
            document.body.innerHTML =
                '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                '<h3 class="entreeSelected" id="entreeSelected2">One Selected</h3>' +
                '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">';

            const choiceSelection = new ChoiceSelection("entree", "entreeSelected", "choiceItemEntree", 1, 0, 1);
            choiceSelection.showSelected($);
            var text1 = $("#entreeSelected1").text();
            expect(text1).toBe("One Selected");
            var border1 = $("#choiceItemEntree1").css("border");
            expect(border1).toBe("5px solid red");
            
            var text2 = $("#entreeSelected2").text();
            expect(text2).toBe("");
            var border2 = $("#choiceItemEntree2").css("border");
            expect(border2).toBe("3px solid lightgray");

            var text3 = $("#entreeSelected3").text();
            expect(text3).toBe("");
            var border3 = $("#choiceItemEntree3").css("border");
            expect(border3).toBe("3px solid lightgray");
        });
    });


    describe('handleMaxOneDrinkSelected function', () => {
        //choiceSelection = new ChoiceSelection("drink", "drinkSelected", "choiceItemDrinkWithSelect", drinkId, 0, drinkMaxQuantity);
        //choiceSelection = new ChoiceSelection("drink", "drinkSelected", "choiceItemDrink", drinkId, 0, drinkMaxQuantity);

        test('Handle Max One Drink Selected with withSelect -- Fountain Drink -- selected and then unselect now', () =>{
            document.body.innerHTML =
                '<h3 class="drinkSelected" id="drinkSelected1">One Selected</h3>' +
                '<h3 class="drinkSelected" id="drinkSelected2"></h3>' +
                '<div class="choiceItemDrinkWithSelect" id="choiceItemDrinkWithSelect1">' +
                '<div class="choiceItemDrink" id="choiceItemDrink2">' +
                '<select name="comboDrink" class="comboDrink" id="comboDrink1" style="height: 37px; padding: 4px 10px; margin: 0px 10px">' +
                    '<option value = "0" selected disable>Choose the flavor</option>' +
                '</select>';

            const choiceSelection = new ChoiceSelection("drink", "drinkSelected", "choiceItemDrinkWithSelect", 1, 0, 1);
            choiceSelection.showSelected($);
            var text1 = $("#drinkSelected1").text();
            expect(text1).toBe("");
            var border1 = $("#choiceItemDrinkWithSelect1").css("border");
            expect(border1).toBe("3px solid lightgray");
        });

        test('Handle Max One Drink Selected without withSelect -- Bottle Water -- selected and then unselect now', () =>{
            document.body.innerHTML =
                '<h3 class="drinkSelected" id="drinkSelected1"></h3>' +
                '<h3 class="drinkSelected" id="drinkSelected2">One Selected</h3>' +
                '<div class="choiceItemDrinkWithSelect" id="choiceItemDrinkWithSelect1">' +
                '<div class="choiceItemDrink" id="choiceItemDrink2">' +
                '<select name="comboDrink" class="comboDrink" id="comboDrink1" style="height: 37px; padding: 4px 10px; margin: 0px 10px">' +
                    '<option value = "0" selected disable>Choose the flavor</option>' +
                '</select>';

            const choiceSelection = new ChoiceSelection("drink", "drinkSelected", "choiceItemDrink", 2, 0, 1);
            choiceSelection.showSelected($);
            var text2 = $("#drinkSelected2").text();
            expect(text2).toBe("");
            var border2 = $("#choiceItemDrink2").css("border");
            expect(border2).toBe("3px solid lightgray");
        });

        test('Handle Max One Drink Selected with withSelect -- Fountain Drink -- not selected and then select now', () =>{
            document.body.innerHTML =
                '<h3 class="drinkSelected" id="drinkSelected1"></h3>' +
                '<h3 class="drinkSelected" id="drinkSelected2">One Selected</h3>' +
                '<div class="choiceItemDrinkWithSelect" id="choiceItemDrinkWithSelect1">' +
                '<div class="choiceItemDrink" id="choiceItemDrink2">' +
                '<select name="comboDrink" class="comboDrink" id="comboDrink1" style="height: 37px; padding: 4px 10px; margin: 0px 10px">' +
                    '<option value = "0" selected disable>Choose the flavor</option>' +
                '</select>';

            const choiceSelection = new ChoiceSelection("drink", "drinkSelected", "choiceItemDrinkWithSelect", 1, 0, 1);
            choiceSelection.showSelected($);
            var text1 = $("#drinkSelected1").text();
            expect(text1).toBe("One Selected");
            var border1 = $("#choiceItemDrinkWithSelect1").css("border");
            expect(border1).toBe("5px solid red");

            var text2 = $("#drinkSelected2").text();
            expect(text2).toBe("");
            var border2 = $("#choiceItemDrink2").css("border");
            expect(border2).toBe("3px solid lightgray");
        });

        test('Handle Max One Drink Selected without withSelect -- Bottle Water -- not selected and then select now', () =>{
            document.body.innerHTML =
                '<h3 class="drinkSelected" id="drinkSelected1">One Selected</h3>' +
                '<h3 class="drinkSelected" id="drinkSelected2"></h3>' +
                '<div class="choiceItemDrinkWithSelect" id="choiceItemDrinkWithSelect1">' +
                '<div class="choiceItemDrink" id="choiceItemDrink2">' +
                '<select name="comboDrink" class="comboDrink" id="comboDrink1" style="height: 37px; padding: 4px 10px; margin: 0px 10px">' +
                    '<option value = "0" disable>Choose the flavor</option>' +
                    '<option value = "1" selected disable>Coke</option>' +
                '</select>';

            const choiceSelection = new ChoiceSelection("drink", "drinkSelected", "choiceItemDrink", 2, 0, 1);
            choiceSelection.showSelected($);
            var text1 = $("#drinkSelected1").text();
            expect(text1).toBe("");
            var border1 = $("#choiceItemDrinkWithSelect1").css("border");
            expect(border1).toBe("3px solid lightgray");
            var value1 = $(".comboDrink :selected").val();
            expect(value1).toBe("0");

            var text2 = $("#drinkSelected2").text();
            expect(text2).toBe("One Selected");
            var border2 = $("#choiceItemDrink2").css("border");
            expect(border2).toBe("5px solid red");
        });
    });    
});

describe('enableAllChoices Function', () => {
    // Included in showSelected Function
});

describe('reachMaxQuantity Function', () => {
    // Included in handleTwoSelected Function
});

describe('handleMaxOneSideSelected Function', () => {
    // Included in showSelected Function
});

describe('handleMaxOneEntreeSelected Function', () => {
    // Included in showSelected Function
});

describe('findOneSelectedSideAndChangeToHalf Function', () => {
    // Included in showSelected Function
});

describe('changeFromHalfToOneSelectedSide Function', () => {
    // Included in showSelected Function
});

describe('disableRestOfSideChoices Function', () => {
    // Included in showSelected Function
});

describe('handleMaxOneDrinkSelected Function', () => {
    // Included in handleMaxOneDrinkSelected Function
});

describe('handleTwoSelected Function', () => {
    const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
    // if maxQuantity > 2, then
    // elementIdPrefix is sideQuantity or entreeQuantity (this indicates the quantity, sideQuantityIncrementDiv/entreeQuantityIncrementDiv, sideQuantityPlus/entreeQuantityPlus, sideQuantityMinus/entreeQuantityMinus)
    // divElementIdPrefix is choiceItemSide or choiceItemEntree
    /*if (maxQuantity > 1) {
        this.incrementDiv = elementIdPrefix + "IncrementDiv";
        this.plus = elementIdPrefix + "Plus";
        this.minus = elementIdPrefix = "Minus";
    }*/
    //choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", entreeId, 0, entreeMaxQuantity);
    test('Handle Two Selected -- the value of the clicked entree is 0, and isAllZeroQuantity is true', () => {
        document.body.innerHTML =
            '<div class="choiceItemEntree" id="choiceItemEntree1">' +
            '</div>' +
            '<div class="choiceItemEntree" id="choiceItemEntree2">' +
            '</div>' +
            '<div class="choiceItemEntree" id="choiceItemEntree3">' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity1" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity2" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>';


        const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 2);
        choiceSelection.showSelected($);
                
        var text1 = $("#entreeQuantity1").val();
        expect(text1).toBe("2");
        var border1 = $("#choiceItemEntree1").css("border");
        expect(border1).toBe("5px solid red");
        var display1 = $("#entreeQuantityIncrementDiv1").css("display");
        expect(display1).toBe("block");
    });

    test('Handle Two Selected -- the value of the clicked entree is 0, and doesOneChoiceHaveTwo is true', () => {
        document.body.innerHTML =
            '<div class="choiceItemEntree" id="choiceItemEntree1">' +
            '</div>' +
            '<div class="choiceItemEntree" id="choiceItemEntree2">' +
            '</div>' +
            '<div class="choiceItemEntree" id="choiceItemEntree3">' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity1" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="2" id="entreeQuantity2" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>';


        const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 2);
        choiceSelection.showSelected($);
                
        var text1 = $("#entreeQuantity1").val();
        expect(text1).toBe("1");
        var border1 = $("#choiceItemEntree1").css("border");
        expect(border1).toBe("5px solid red");
        var display1 = $("#entreeQuantityIncrementDiv1").css("display");
        expect(display1).toBe("block");

        var text2 = $("#entreeQuantity2").val();
        expect(text2).toBe("1");

        var disabled3 = $("#choiceItemEntree3").prop("disabled");
        expect(disabled3).toBeTruthy();
        var backgroundColor3 = $("#choiceItemEntree3").css("background-color");
        expect(backgroundColor3).toBe("lightgray");
        //$("#" + divElementName + choiceId).prop('disabled', true);
        //$("#" + divElementName + choiceId).css('background-color', 'lightgray');
    });

    test('Handle Two Selected -- the value of the clicked entree is 0, and reachMaxQuantity is false -- this means that only 1 quantity is selected at entreeQuantity2', () => {
        document.body.innerHTML =
            '<div class="choiceItemEntree" id="choiceItemEntree1">' +
            '</div>' +
            '<div class="choiceItemEntree" id="choiceItemEntree2">' +
            '</div>' +
            '<div class="choiceItemEntree" id="choiceItemEntree3">' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity1" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity2" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>';


        const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 2);
        choiceSelection.showSelected($);
                
        var text1 = $("#entreeQuantity1").val();
        expect(text1).toBe("1");
        var border1 = $("#choiceItemEntree1").css("border");
        expect(border1).toBe("5px solid red");
        var display1 = $("#entreeQuantityIncrementDiv1").css("display");
        expect(display1).toBe("block");

        var text2 = $("#entreeQuantity2").val();
        expect(text2).toBe("1");

        var disabled3 = $("#choiceItemEntree3").prop("disabled");
        expect(disabled3).toBeTruthy();
        var backgroundColor3 = $("#choiceItemEntree3").css("background-color");
        expect(backgroundColor3).toBe("lightgray");
        //$("#" + divElementName + choiceId).prop('disabled', true);
        //$("#" + divElementName + choiceId).css('background-color', 'lightgray');
    });

    test('Handle Two Selected -- the value of the clicked entree is 1, -- entreeQuantity2 is 1', () => {
        document.body.innerHTML =
            '<div class="choiceItemEntree" id="choiceItemEntree1">' +
            '</div>' +
            '<div class="choiceItemEntree" id="choiceItemEntree2">' +
            '</div>' +
            '<div class="choiceItemEntree" id="choiceItemEntree3">' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity1" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity2" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>';


        const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 2);
        choiceSelection.showSelected($);
                
        var text1 = $("#entreeQuantity1").val();
        expect(text1).toBe("0");
        var border1 = $("#choiceItemEntree1").css("border");
        expect(border1).toBe("3px solid lightgray");
        var display1 = $("#entreeQuantityIncrementDiv1").css("display");
        expect(display1).toBe("none");

        var text2 = $("#entreeQuantity2").val();
        expect(text2).toBe("2");

        var disabled3 = $("#choiceItemEntree3").prop("disabled");
        expect(disabled3).toBeFalsy();
    });

    test('Handle Two Selected -- the value of the clicked entree is 2', () => {
        document.body.innerHTML =
            '<div class="choiceItemEntree" id="choiceItemEntree1">' +
            '</div>' +
            '<div class="choiceItemEntree" id="choiceItemEntree2">' +
            '</div>' +
            '<div class="choiceItemEntree" id="choiceItemEntree3">' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="2" id="entreeQuantity1" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity2" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>' +
            '<div class="selectedDiv">' +
                '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                    '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                    '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                '</div>' +
            '</div>';


        const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 2);
        choiceSelection.showSelected($);
                
        var text1 = $("#entreeQuantity1").val();
        expect(text1).toBe("0");
        var border1 = $("#choiceItemEntree1").css("border");
        expect(border1).toBe("3px solid lightgray");
        var display1 = $("#entreeQuantityIncrementDiv1").css("display");
        expect(display1).toBe("none");

        var text2 = $("#entreeQuantity2").val();
        expect(text2).toBe("0");
        var disabled2 = $("#choiceItemEntree2").prop("disabled");
        expect(disabled2).toBeFalsy();

        var text3 = $("#entreeQuantity3").val();
        expect(text3).toBe("0");
        var disabled3 = $("#choiceItemEntree3").prop("disabled");
        expect(disabled3).toBeFalsy();
    });
});

describe('doesOneChoiceHaveTwo Function', () => {
    // Included in handleTwoSelected Function
});

describe('handleThreeSelected Function', () => {
    const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
    // if maxQuantity > 2, then
    // elementIdPrefix is sideQuantity or entreeQuantity (this indicates the quantity, sideQuantityIncrementDiv/entreeQuantityIncrementDiv, sideQuantityPlus/entreeQuantityPlus, sideQuantityMinus/entreeQuantityMinus)
    // divElementIdPrefix is choiceItemSide or choiceItemEntree
    /*if (maxQuantity > 1) {
        this.incrementDiv = elementIdPrefix + "IncrementDiv";
        this.plus = elementIdPrefix + "Plus";
        this.minus = elementIdPrefix = "Minus";
    }*/
    //choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", entreeId, 0, entreeMaxQuantity);
    describe('Handle Three Selected -- Quantity is 0', () => {
        test('Handle Three Selected -- Quantity is 0, isAllZeroQuantity is true', () => {
            document.body.innerHTML =
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree4">' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity1" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity2" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected4"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv4" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus4"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity4" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus4"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>';

            const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 3);
            choiceSelection.showSelected($);
                    
            var text1 = $("#entreeQuantity1").val();
            expect(text1).toBe("3");
            var border1 = $("#choiceItemEntree1").css("border");
            expect(border1).toBe("5px solid red");
            var display1 = $("#entreeQuantityIncrementDiv1").css("display");
            expect(display1).toBe("block");
        });

        test('Handle Three Selected -- Quantity is 0, doesOneChoiceHaveThree is true', () => {
            document.body.innerHTML =
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree4">' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity1" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="3" id="entreeQuantity2" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected4"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv4" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus4"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity4" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus4"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>';

            const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 3);
            choiceSelection.showSelected($);
                    
            var text1 = $("#entreeQuantity1").val();
            expect(text1).toBe("1");
            var border1 = $("#choiceItemEntree1").css("border");
            expect(border1).toBe("5px solid red");
            var display1 = $("#entreeQuantityIncrementDiv1").css("display");
            expect(display1).toBe("block");

            var text1 = $("#entreeQuantity2").val();
            expect(text1).toBe("2");

        });

        test('Handle Three Selected -- Quantity is 0, doesOneChoiceHaveTwoAndOneChoiceHaveOne is true', () => {
            document.body.innerHTML =
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree4">' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity1" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="2" id="entreeQuantity2" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity3" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected4"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv4" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus4"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity4" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus4"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>';

            const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 3);
            choiceSelection.showSelected($);
                    
            var text1 = $("#entreeQuantity1").val();
            expect(text1).toBe("1");
            var border1 = $("#choiceItemEntree1").css("border");
            expect(border1).toBe("5px solid red");
            var display1 = $("#entreeQuantityIncrementDiv1").css("display");
            expect(display1).toBe("block");

            var text2 = $("#entreeQuantity2").val();
            expect(text2).toBe("1");

            var disabled4 = $("#choiceItemEntree4").prop("disabled");
            expect(disabled4).toBeTruthy();
            var backgroundColor4 = $("#choiceItemEntree4").css("background-color");
            expect(backgroundColor4).toBe("lightgray");
            //$("#" + divElementName + choiceId).prop('disabled', true);
            //$("#" + divElementName + choiceId).css('background-color', 'lightgray');
        });

        test('Handle Three Selected -- Quantity is 0, doesOneChoiceHaveOneAndOneChoiceHaveOne is true', () => {
            document.body.innerHTML =
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree4">' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity1" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity2" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity3" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected4"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv4" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus4"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity4" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus4"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>';

            const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 3);
            choiceSelection.showSelected($);
                    
            var text1 = $("#entreeQuantity1").val();
            expect(text1).toBe("1");
            var border1 = $("#choiceItemEntree1").css("border");
            expect(border1).toBe("5px solid red");
            var display1 = $("#entreeQuantityIncrementDiv1").css("display");
            expect(display1).toBe("block");

            var text2 = $("#entreeQuantity2").val();
            expect(text2).toBe("1");

            var text3 = $("#entreeQuantity3").val();
            expect(text3).toBe("1");

            var disabled4 = $("#choiceItemEntree4").prop("disabled");
            expect(disabled4).toBeTruthy();
            var backgroundColor4 = $("#choiceItemEntree4").css("background-color");
            expect(backgroundColor4).toBe("lightgray");
            //$("#" + divElementName + choiceId).prop('disabled', true);
            //$("#" + divElementName + choiceId).css('background-color', 'lightgray');
        });

        test('Handle Three Selected -- Quantity is 0, doesOneChoiceHaveOneAndOneChoiceHaveOne is false -- only choiceItem2 is 1 -- for "} else {" statement line: 323', () => {
            document.body.innerHTML =
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree4">' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity1" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity2" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected4"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv4" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus4"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity4" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus4"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>';

            const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 3);
            choiceSelection.showSelected($);
                    
            var text1 = $("#entreeQuantity1").val();
            expect(text1).toBe("1");
            var border1 = $("#choiceItemEntree1").css("border");
            expect(border1).toBe("5px solid red");
            var display1 = $("#entreeQuantityIncrementDiv1").css("display");
            expect(display1).toBe("block");

            var text2 = $("#entreeQuantity2").val();
            expect(text2).toBe("1");

            var text3 = $("#entreeQuantity3").val();
            expect(text3).toBe("0");

            var disabled4 = $("#choiceItemEntree4").prop("disabled");
            expect(disabled4).toBeFalsy();
        });

        test('Handle Three Selected -- Quantity is 0, doesOneChoiceHaveOneAndOneChoiceHaveOne is false -- only choiceItem2 is 2 -- for "} else {" statement line: 323', () => {
            document.body.innerHTML =
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree4">' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity1" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="2" id="entreeQuantity2" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected4"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv4" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus4"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity4" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus4"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>';

            const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 3);
            choiceSelection.showSelected($);
                    
            var text1 = $("#entreeQuantity1").val();
            expect(text1).toBe("1");
            var border1 = $("#choiceItemEntree1").css("border");
            expect(border1).toBe("5px solid red");
            var display1 = $("#entreeQuantityIncrementDiv1").css("display");
            expect(display1).toBe("block");

            var text2 = $("#entreeQuantity2").val();
            expect(text2).toBe("2");

            var text3 = $("#entreeQuantity3").val();
            expect(text3).toBe("0");

            var disabled4 = $("#choiceItemEntree4").prop("disabled");
            expect(disabled4).toBeFalsy();
        });
    });

    describe('Handle Three Selected -- Quantity is not 0', () => {
        test('Handle Three Selected -- Quantity is not 0, Quantity is 1 and others are all 0', () => {
            document.body.innerHTML =
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree4">' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity1" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity2" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected4"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv4" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus4"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity4" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus4"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>';

            const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 3);
            choiceSelection.showSelected($);
                    
            var text1 = $("#entreeQuantity1").val();
            expect(text1).toBe("0");
            var border1 = $("#choiceItemEntree1").css("border");
            expect(border1).toBe("3px solid lightgray");
            var display1 = $("#entreeQuantityIncrementDiv1").css("display");
            expect(display1).toBe("none");

            var text2 = $("#entreeQuantity2").val();
            expect(text2).toBe("0");
            //var border2 = $("#choiceItemEntree2").css("border");
            //expect(border2).toBe("3px solid lightgray");
            var display2 = $("#entreeQuantityIncrementDiv2").css("display");
            expect(display2).toBe("none");

            var text3 = $("#entreeQuantity3").val();
            expect(text3).toBe("0");
            //var border3 = $("#choiceItemEntree3").css("border");
            //expect(border3).toBe("3px solid lightgray");
            var display3 = $("#entreeQuantityIncrementDiv3").css("display");
            expect(display3).toBe("none");

            var text4 = $("#entreeQuantity4").val();
            expect(text4).toBe("0");
            //var border4 = $("#choiceItemEntree4").css("border");
            //expect(border4).toBe("3px solid lightgray");
            var display4 = $("#entreeQuantityIncrementDiv4").css("display");
            expect(display4).toBe("none");
        });

        test('Handle Three Selected -- Quantity is not 0, Quantity is 1 and second is 1 and third is 1', () => {
            document.body.innerHTML =
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree4">' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity1" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity2" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity3" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected4"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv4" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus4"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity4" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus4"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>';

            const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 0, 3);
            choiceSelection.showSelected($);
                    
            var text1 = $("#entreeQuantity1").val();
            expect(text1).toBe("0");
            var border1 = $("#choiceItemEntree1").css("border");
            expect(border1).toBe("3px solid lightgray");
            var display1 = $("#entreeQuantityIncrementDiv1").css("display");
            expect(display1).toBe("none");

            var text2 = $("#entreeQuantity2").val();
            expect(text2).toBe("2");
            var display2 = $("#entreeQuantityIncrementDiv2").css("display");
            expect(display2).toBe("none");

            var text3 = $("#entreeQuantity3").val();
            expect(text3).toBe("1");
            var display3 = $("#entreeQuantityIncrementDiv3").css("display");
            expect(display3).toBe("none");

            var text4 = $("#entreeQuantity4").val();
            expect(text4).toBe("0");
            var display4 = $("#entreeQuantityIncrementDiv4").css("display");
            expect(display4).toBe("none");
        });
    });

    describe('Handle Three Selected -- Quantity is +1 -- click plus button inclease quantity 1', () => {
        test('Handle Three Selected -- Quantity is +1, reachMaxQuantity is false', () => {
            document.body.innerHTML =
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree4">' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="2" id="entreeQuantity1" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity2" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected4"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv4" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus4"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity4" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus4"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>';

            const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 1, 3);
            choiceSelection.showSelected($);
                    
            var text1 = $("#entreeQuantity1").val();
            expect(text1).toBe("3");
        });

        test('Handle Three Selected -- Quantity is +1, reachMaxQuantity is true', () => {
            document.body.innerHTML =
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree4">' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="3" id="entreeQuantity1" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity2" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected4"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv4" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus4"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity4" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus4"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>';

            const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, 1, 3);
            choiceSelection.showSelected($);
               
            // Nothing changed -- text1 is still 3
            var text1 = $("#entreeQuantity1").val();
            expect(text1).toBe("3");
        });
    });

    describe('Handle Three Selected -- Quantity is -1 -- click plus button declease quantity 1', () => {
        test('Handle Three Selected -- Quantity is -1 -- original quantity is 1', () => {
            document.body.innerHTML =
                '<div class="choiceItemEntree" id="choiceItemEntree1">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree2">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree3">' +
                '</div>' +
                '<div class="choiceItemEntree" id="choiceItemEntree4">' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected1"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv1" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus1"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity1" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus1"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv2" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus2"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity2" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus2"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected3"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv3" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus3"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity3" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus3"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="selectedDiv">' +
                    '<h3 class="entreeSelected" id="entreeSelected4"></h3>' +
                    '<div class="entreeQuantityIncrementDiv mx-auto" id="entreeQuantityIncrementDiv4" style="display: none;>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityMinus" id="entreeQuantityMinus4"><i class="fas fa-minus"></i></button>' +
                        '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity4" disabled>' +
                        '<button type="button" class="btn bg-light border rounded-circle entreeQuantityPlus" id="entreeQuantityPlus4"><i class="fas fa-plus"></i></button>' +
                    '</div>' +
                '</div>';

            const choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", 1, -1, 3);
            choiceSelection.showSelected($);
                    
            var text1 = $("#entreeQuantity1").val();
            expect(text1).toBe("0");
            var border1 = $("#choiceItemEntree1").css("border");
            expect(border1).toBe("3px solid lightgray");
            var display1 = $("#entreeQuantityIncrementDiv1").css("display");
            expect(display1).toBe("none");

            var text2 = $("#entreeQuantity2").val();
            expect(text2).toBe("2");

            var disabled3 = $("#entreeQuantityIncrementDiv3").prop("disabled");
            expect(disabled3).toBeFalsy;
            var backgroundColor3 = $("#choiceItemEntree3").css("background-color");
            expect(backgroundColor3).toBe("white");

            var disabled4 = $("#entreeQuantityIncrementDiv4").prop("disabled");
            expect(disabled4).toBeFalsy;
            var backgroundColor4 = $("#choiceItemEntree4").css("background-color");
            expect(backgroundColor4).toBe("white");          
        });
    });
});

describe('isAllZeroQuantity Function', () => {
    // Included in handleTwoSelected Function
});

describe('doesOneChoiceHaveThree Function', () => {
    // Included in handleThreeSelected Function
});

describe('doesOneChoiceHaveTwoAndOneChoiceHaveOne', () => {
    // Included in handleThreeSelected Function
});

describe('doesOneChoiceHaveTwoAndOneChoiceHaveOne Function', () => {
    // Included in handleThreeSelected Function
});

describe('disableRestOfChoices Function', () => {
    // Included in handleTwoSelected Function
});