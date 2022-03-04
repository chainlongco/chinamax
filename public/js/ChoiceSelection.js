//const {CommonFunction} = require('./CommonFunction');

class ChoiceSelection {
    constructor(category, elementIdPrefix, divElementIdPrefix, id, quantity, maxQuantity) {
        // if maxQuantity = 1, then
        //  elementIdPrefix is sideSelected or entreeSelected or drinkSelected
        //  divElementIdPrefix is choiceItemSide or choiceItemEntree or choiceItemDrink

        // if maxQuantity > 2, then
        // elementIdPrefix is sideQuantity or entreeQuantity (this indicates the quantity, sideQuantityIncrementDiv/entreeQuantityIncrementDiv, sideQuantityPlus/entreeQuantityPlus, sideQuantityMinus/entreeQuantityMinus)
        // divElementIdPrefix is choiceItemSide or choiceItemEntree
        this.category = category;
        this.elementIdPrefix = elementIdPrefix;
        this.divElementIdPrefix = divElementIdPrefix;
        this.id = id;
        this.quantity = quantity;   // +1 or -1 from sideQuantityPlus/entreeQuantityPlus, sideQuantityMinus/entreeQuantityMinus
        this.maxQuantity = maxQuantity;
        if (maxQuantity > 1) {
            this.incrementDiv = elementIdPrefix + "IncrementDiv";
            this.plus = elementIdPrefix + "Plus";
            this.minus = elementIdPrefix = "Minus";
        }
        
    }

    showSelected($) {
        //var count = $('.' + this.elementIdPrefix).length;
        if (this.quantity == 0) {   // This handles when clicks side or entree elements
            if (this.maxQuantity == 1) {
                if (this.category == 'side') {
                    this.handleMaxOneSideSelected($);
                } else if (this.category == 'entree') {
                    this.handleMaxOneEntreeSelected($);
                } else if (this.category == 'drink') {
                    this.handleMaxOneDrinkSelected($);
                }
            } else if (this.maxQuantity == 2) { // Only for entree
                this.handleTwoSelected($);
            } else if (this.maxQuantity == 3) { // For both side and entree
                this.handleThreeSelected($);
            }
        } else if (this.quantity == 1) {
            if (!this.reachMaxQuantity($)) {
                var originalValue = Number($("#" + this.elementIdPrefix + this.id).val());
                $("#" + this.elementIdPrefix + this.id).val(originalValue + 1);
            }
            
        } else if (this.quantity == -1) {
            var originalValue = Number($("#" + this.elementIdPrefix + this.id).val());
            $("#" + this.elementIdPrefix + this.id).val(originalValue -1);
            if (originalValue == 1) {
                $("#" + this.divElementIdPrefix + this.id).css("border","3px solid lightgray");
                $("#" + this.incrementDiv + this.id).css("display", "none");
            }
            this.addChoiceQuantityToOther(1, this.id, $);
            this.enableAllChoices($);
        }
    }

    /* Shared ********* Start */
    enableAllChoices($) {
        $('.' + this.divElementIdPrefix).prop('disabled', false);
        $('.' + this.divElementIdPrefix).css('background-color', 'white');
    }

    reachMaxQuantity($) {
        var totalQuantity = 0;
        var elementName = this.elementIdPrefix;
        var choiceElements = $("." + this.elementIdPrefix).toArray();
        choiceElements.forEach(function(choiceElement) {
            var commonFunction = new CommonFunction();
            var choiceId = commonFunction.retrieveId(elementName, choiceElement.id);
            totalQuantity += Number($("#" + elementName + choiceId).val());     
        });
        if (totalQuantity == this.maxQuantity) {
            return true;
        } else {
            return false;
        }
    }
    /* Shared ********* End */


    /* Max One ******************** Start */
    handleMaxOneSideSelected($) {
        if ($("#" + this.elementIdPrefix + this.id).text() == "One Selected") {
            $("#" + this.elementIdPrefix + this.id).text("");
            $("#" + this.divElementIdPrefix + this.id).css("border","3px solid lightgray");
        } else if ($("#" + this.elementIdPrefix + this.id).text() == "") {
            if (this.findOneSelectedSideAndChangeToHalf($)) {
                $("#" + this.elementIdPrefix + this.id).text("Half Selected");
                $("#" + this.divElementIdPrefix + this.id).css("border","5px solid red");
                this.disableRestOfSideChoices($);
            } else {
                $("#" + this.elementIdPrefix + this.id).text("One Selected");
                $("#" + this.divElementIdPrefix + this.id).css("border","5px solid red");
            }
        } else if ($("#" + this.elementIdPrefix + this.id).text() == "Half Selected") {
            $("#" + this.elementIdPrefix + this.id).text("");
            $("#" + this.divElementIdPrefix + this.id).css("border","3px solid lightgray");
            this.changeFromHalfToOneSelectedSide($);
            this.enableAllChoices($);
        }

        /*if ($("#sideSelected" + sideId).text() == "One Selected") {
            $("#sideSelected" + sideId).text("");
            $("#choiceItemSide" + sideId).css("border","3px solid lightgray");
        } else if ($("#sideSelected" + sideId).text() == "") {
            if (findOneSelectedSideAndChangeToHalf($)) {
                $("#sideSelected" + sideId).text("Half Selected");
                $("#choiceItemSide" + sideId).css("border","5px solid red");
                disableRestOfSideChoices($);
            } else {
                $("#sideSelected" + sideId).text("One Selected");
                $("#choiceItemSide" + sideId).css("border","5px solid red");
            }
        } else if ($("#sideSelected" + sideId).text() == "Half Selected") {
            $("#sideSelected" + sideId).text("");
            $("#choiceItemSide" + sideId).css("border","3px solid lightgray");
            changeFromHalfToOneSelectedSide($);
            enableAllChoices($);
        }*/
    }

    handleMaxOneEntreeSelected($) {
        if ($('#' + this.elementIdPrefix + this.id).text() == "One Selected") {
            $('#' + this.elementIdPrefix + this.id).text("");
            $('#' + this.divElementIdPrefix + this.id).css("border", "3px solid lightgray");
        } else {
            // Remove all
            $('.' + this.elementIdPrefix).text("");
            $('.' + this.divElementIdPrefix).css("border", "3px solid lightgray");
            // Select One
            $('#' + this.elementIdPrefix + this.id).text("One Selected");
            $('#' + this.divElementIdPrefix + this.id).css("border", "5px solid red");
        }   
    }

    findOneSelectedSideAndChangeToHalf($) {
        var isOneSelected = false;
        var sideElements = $("." + this.divElementIdPrefix).toArray();
        var divElementName = this.divElementIdPrefix;
        var elementName = this.elementIdPrefix;
        sideElements.forEach(function(sideElement) {
            var commonFunction = new CommonFunction();
            var sideId = commonFunction.retrieveId(divElementName, sideElement.id);
            if ($("#" + elementName + sideId).text() == "One Selected") {
                $("#" + elementName + sideId).text("Half Selected");
                isOneSelected = true;
            }
        });
        return isOneSelected;
    }

    /*function findOneSelectedSideAndChangeToHalf() {
            var isOneSelected = false;
            var sideElements = $(".choiceItemSide").toArray();
            sideElements.forEach(function(sideElement) {
                var commonFunction = new CommonFunction();
                var sideId = commonFunction.retrieveId("choiceItemSide", sideElement.id);
                if ($("#sideSelected" + sideId).text() == "One Selected") {
                    $("#sideSelected" + sideId).text("Half Selected");
                    isOneSelected = true;
                }
            });
            return isOneSelected;
        }*/

    changeFromHalfToOneSelectedSide($) {
        var sideElements = $("." + this.divElementIdPrefix).toArray();
        var divElementName = this.divElementIdPrefix;
        var elementName = this.elementIdPrefix;
        sideElements.forEach(function(sideElement) {
            var commonFunction = new CommonFunction();
            var sideId = commonFunction.retrieveId(divElementName, sideElement.id);
            if ($("#" + elementName + sideId).text() == "Half Selected") {
                $("#" + elementName + sideId).text("One Selected");
            }
        });

        /*var sideElements = $(".choiceItemSide").toArray()
        sideElements.forEach(function(sideElement) {
            var commonFunction = new CommonFunction();
            var sideId = commonFunction.retrieveId("choiceItemSide", sideElement.id);
            if ($("#sideSelected" + sideId).text() == "Half Selected") {
                $("#sideSelected" + sideId).text("One Selected");
            }
        });*/
    }   

    disableRestOfSideChoices($) {
        var sideElements = $("." + this.divElementIdPrefix).toArray()
        var divElementName = this.divElementIdPrefix;
        var elementName = this.elementIdPrefix;
        sideElements.forEach(function(sideElement) {
            var commonFunction = new CommonFunction();
            var sideId = commonFunction.retrieveId(divElementName, sideElement.id);
            if ($("#" + elementName + sideId).text() != "Half Selected") {
                $("#" + divElementName + sideId).prop('disabled', true);
                $("#" + divElementName + sideId).css('background-color', 'lightgray');
            }
        });
    }

    handleMaxOneDrinkSelected($) {
        var index = this.divElementIdPrefix.indexOf("WithSelect");
        if ($('#' + this.elementIdPrefix + this.id).text() == "One Selected") {
            if (index >= 0) {
                if ($('.comboDrink').val() == 0) {
                    $('#' + this.elementIdPrefix + this.id).text("");
                    $('#' + this.divElementIdPrefix + this.id).css("border", "3px solid lightgray");
                }
            } else {    // Bottle Water unselected in this case
                $('#' + this.elementIdPrefix + this.id).text("");
                $('#' + this.divElementIdPrefix + this.id).css("border", "3px solid lightgray");
            }
        } else {
            if (index >= 0) {
                // Remove all
                var divElementIdPrefixWithoutSelect = this.divElementIdPrefix.substr(0, index);
                $('.' + this.elementIdPrefix).text("");
                $('.' + this.divElementIdPrefix).css("border", "3px solid lightgray");
                $('.' + divElementIdPrefixWithoutSelect).css("border", "3px solid lightgray");
                // Select One
                $('#' + this.elementIdPrefix + this.id).text("One Selected");
                $('#' + this.divElementIdPrefix + this.id).css("border", "5px solid red");
            } else {
                // Remove all
                $('.' + this.elementIdPrefix).text("");
                $('.' + this.divElementIdPrefix).css("border", "3px solid lightgray");
                $('.' + this.divElementIdPrefix + "WithSelect").css("border", "3px solid lightgray");
                $('.comboDrink').val(0);
                // Select One
                $('#' + this.elementIdPrefix + this.id).text("One Selected");
                $('#' + this.divElementIdPrefix + this.id).css("border", "5px solid red");
            }
            
        }
    }
    /* Max One ******************** End */
        

    /* Max Two ******************** Start */
    // if maxQuantity >= 2, then
        // elementIdPrefix is sideQuantity or entreeQuantity (this indicates the quantity, sideQuantityIncrementDiv/entreeQuantityIncrementDiv, sideQuantityPlus/entreeQuantityPlus, sideQuantityMinus/entreeQuantityMinus)
        // divElementIdPrefix is choiceItemSide or choiceItemEntree
    handleTwoSelected($) {
        if ($("#" + this.elementIdPrefix + this.id).val() == 0) {
            // None of entree is selected
            if (this.isAllZeroQuantity($)) {
                $("#" + this.incrementDiv + this.id).css("display", "block");
                $("#" + this.elementIdPrefix + this.id).val(this.maxQuantity);
                $("#" + this.divElementIdPrefix + this.id).css("border", "5px solid red");
            } else if (this.doesOneChoiceHaveTwo($)) {  // One of side/entree is selected == 2
                $("#" + this.incrementDiv + this.id).css("display", "block");
                $("#" + this.elementIdPrefix + this.id).val(1);
                $("#" + this.divElementIdPrefix + this.id).css("border", "5px solid red");
                this.disableRestOfChoices($);
            } else if (!this.reachMaxQuantity($)) {  // This scenario is if maxQuantity is 2, there is 2 quantity entree selected. Clicking Minus button to become 1 quantity. It become 1 quantity available to select. Then now, I click the one which has not been selected.
                $("#" + this.incrementDiv + this.id).css("display", "block");
                $("#" + this.elementIdPrefix + this.id).val(1);
                $("#" + this.divElementIdPrefix + this.id).css("border", "5px solid red");
                if (this.reachMaxQuantity) {
                    this.disableRestOfChoices($);
                }
            }
        } else if (Number($("#" + this.elementIdPrefix + this.id).val()) != 0) {
            var choiceQuantity = Number($("#" + this.elementIdPrefix + this.id).val());
            $("#" + this.incrementDiv + this.id).css("display", "none");    
            $("#" + this.elementIdPrefix + this.id).val(0);   
            $("#" + this.divElementIdPrefix + this.id).css("border", "3px solid lightgray");
            if (choiceQuantity == 1) {
                this.addChoiceQuantityToOther(choiceQuantity, this.id, $);
                this.enableAllChoices($);    // Only for 2 entrees all of them have 1 quantity
            }
        }
    }

    doesOneChoiceHaveTwo($) {
        var exists = false;
        var elementName = this.elementIdPrefix; // It does not work this.elementIdPrefix in the forEach loop
        var sideElements = $("." + this.elementIdPrefix).toArray();
        sideElements.forEach(function(sideElement) {
            var commonFunction = new CommonFunction();
            var sideId = commonFunction.retrieveId(elementName, sideElement.id);
            if ($("#" + elementName + sideId).val() == 2) {
                $("#" + elementName + sideId).val(1);
                exists = true;
            }
        });
        return exists;
    }
    /* Max Two ******************** End */


    /* Max Three ******************** Start */
    // if maxQuantity >= 2, then
        // elementIdPrefix is sideQuantity or entreeQuantity (this indicates the quantity, sideQuantityIncrementDiv/entreeQuantityIncrementDiv, sideQuantityPlus/entreeQuantityPlus, sideQuantityMinus/entreeQuantityMinus)
        // divElementIdPrefix is choiceItemSide or choiceItemEntree
    handleThreeSelected($) {
        if ($("#" + this.elementIdPrefix + this.id).val() == 0) {
            // None of side/entree is selected
            if (this.isAllZeroQuantity($)) {
                $("#" + this.incrementDiv + this.id).css("display", "block");
                $("#" + this.elementIdPrefix + this.id).val(this.maxQuantity);
                $("#" + this.divElementIdPrefix + this.id).css("border", "5px solid red");
            } else if (this.doesOneChoiceHaveThree($)) {  // One of side/entree is selected == 3
                $("#" + this.incrementDiv + this.id).css("display", "block");
                $("#" + this.elementIdPrefix + this.id).val(1);
                $("#" + this.divElementIdPrefix + this.id).css("border", "5px solid red");
            } else if (this.doesOneChoiceHaveTwoAndOneChoiceHaveOne($)) {    // two of side/entree are selected, one is 2, one is 1
                $("#" + this.incrementDiv + this.id).css("display", "block");
                $("#" + this.elementIdPrefix + this.id).val(1);
                $("#" + this.divElementIdPrefix + this.id).css("border", "5px solid red");
                this.disableRestOfChoices($);
            } else if (this.doesOneChoiceHaveOneAndOneChoiceHaveOne($)) {
                // This scenario comes from clicking other choiceItems' Minus button to become other choiceItems are:
                // choiceItem2 is 1 and choiceItem3 is 1 (Originally, choiceItem2 has 3, then click minus button to become 1, then click choiceItem3 to become 1)
                $("#" + this.incrementDiv + this.id).css("display", "block");
                $("#" + this.elementIdPrefix + this.id).val(1);
                $("#" + this.divElementIdPrefix + this.id).css("border", "5px solid red");
                this.disableRestOfChoices($);
            } else {    
                // This scenario comes from clicking other choiceItems' Minus button to become other choiceItems are:
                // 1. choiceItem2 is 2 (from 3 to 2)
                // 2. choiceItem2 is 1 (Originally, choiceItem2 has 3, then click minus button to become 1)
                $("#" + this.incrementDiv + this.id).css("display", "block");
                $("#" + this.elementIdPrefix + this.id).val(1);
                $("#" + this.divElementIdPrefix + this.id).css("border", "5px solid red");
            }
        } else if (Number($("#" + this.elementIdPrefix + this.id).val()) != 0) {
            var choiceQuantity = Number($("#" + this.elementIdPrefix + this.id).val());
            $("#" + this.incrementDiv + this.id).css("display", "none");    
            $("#" + this.elementIdPrefix + this.id).val(0);   
            $("#" + this.divElementIdPrefix + this.id).css("border", "3px solid lightgray");
            if (choiceQuantity != 3) {
                this.addChoiceQuantityToOther(choiceQuantity, this.id, $);
            }
            if (choiceQuantity == 1) {
                this.enableAllChoices($);    // Only for 3 entrees all of them have 1 quantity
            }
        }

        /*if ($("#sideQuantity" + this.id).val() == 0) {
            // None of side is selected
            if (this.isAllZeroQuantity($)) {
                $("#sideQuantityIncrementDiv" + this.id).css("display", "block");
                $("#sideQuantity" + this.id).val(maxQuantity);
                $("#choiceItemSide" + this.id).css("border", "5px solid red");
            } else if (this.doesOneChoiceHaveThree($)) {  // One of side is selected == 3
                $("#sideQuantityIncrementDiv" + this.id).css("display", "block");
                $("#sideQuantity" + this.id).val(1);
                $("#choiceItemSide" + this.id).css("border", "5px solid red");
            } else if (this.doesOneChoiceHaveTwoAndOneChoiceHaveOne($)) {    // two of side/entree are selected, one is 2, one is 1
                $("#sideQuantityIncrementDiv" + this.id).css("display", "block");
                $("#sideQuantity" + this.id).val(1);
                $("#choiceItemSide" + this.id).css("border", "5px solid red");
            }
        } else if ($("#sideQuantity" + this.id).val() != 0) {
            var sideQuantity = $("#sideQuantity" + this.id).val();
            if (sideQuantity != 3) {
                this.addSideQuantityToOther(sideQuantity, this.id);
            } 
            $("#sideQuantityIncrementDiv" + this.id).css("display", "none");    
            $("#sideQuantity" + this.id).val(0);   
            $("#choiceItemSide" + this.id).css("border", "3px solid lightgray");
        }*/
    }

    isAllZeroQuantity($) {
        var isAllZero = true;
        var elementName = this.elementIdPrefix; // It does not work this.elementIdPrefix in the forEach loop
        var sideElements = $("." + this.elementIdPrefix).toArray();
        sideElements.forEach(function(sideElement) {
            var commonFunction = new CommonFunction();
            var sideId = commonFunction.retrieveId(elementName, sideElement.id);
            if ($("#" + elementName + sideId).val() != 0) {
                isAllZero = false;
            }
        });
        return isAllZero;
    }

    doesOneChoiceHaveThree($) {
        var exists = false;
        var elementName = this.elementIdPrefix; // It does not work this.elementIdPrefix in the forEach loop
        var sideElements = $("." + this.elementIdPrefix).toArray();
        sideElements.forEach(function(sideElement) {
            var commonFunction = new CommonFunction();
            var sideId = commonFunction.retrieveId(elementName, sideElement.id);
            if ($("#" + elementName + sideId).val() == 3) {
                $("#" + elementName + sideId).val(2);
                exists = true;
            }
        });
        return exists;
    }

    doesOneChoiceHaveTwoAndOneChoiceHaveOne($) {
        var oneExists = false;
        var twoExists = false;
        var sideIdOfTwo = 0;
        var elementName = this.elementIdPrefix; // It does not work this.elementIdPrefix in the forEach loop
        var sideElements = $("." + this.elementIdPrefix).toArray();
        sideElements.forEach(function(sideElement) {
            var commonFunction = new CommonFunction();
            var sideId = commonFunction.retrieveId(elementName, sideElement.id);
            if ($("#" + elementName + sideId).val() == 1) {
                oneExists = true;
            }
            if ($("#" + elementName + sideId).val() == 2) {
                twoExists = true;
                sideIdOfTwo = sideId;
            }
        });
        if (oneExists && twoExists) {
            $("#" + this.elementIdPrefix + sideIdOfTwo).val(1);
        }
        return oneExists && twoExists;
    }

    doesOneChoiceHaveOneAndOneChoiceHaveOne($) {
        var countOfValueOne = 0;
        var elementName = this.elementIdPrefix; // It does not work this.elementIdPrefix in the forEach loop
        var sideElements = $("." + this.elementIdPrefix).toArray();
        sideElements.forEach(function(sideElement) {
            var commonFunction = new CommonFunction();
            var sideId = commonFunction.retrieveId(elementName, sideElement.id);
            if ($("#" + elementName + sideId).val() == 1) {
               countOfValueOne++;
            }
            if ($("#" + elementName + sideId).val() > 1) {
                return false;
            }
        });
        if (countOfValueOne == 2) {
            return true;
        } else {
            return false;
        }
    }

    addChoiceQuantityToOther(choiceQuantity, currentId, $) {
        var unselectedQuantity = choiceQuantity;
        var elementName = this.elementIdPrefix; // It does not work this.elementIdPrefix in the forEach loop
        var choiceElements = $("." + this.elementIdPrefix).toArray();
        choiceElements.forEach(function(choiceElement) {
            var commonFunction = new CommonFunction();
            var choiceId = commonFunction.retrieveId(elementName, choiceElement.id);
            if (($("#" + elementName + choiceId).val() != 0) && (choiceId != currentId)) {   // (choiceId != currentId) is not adding the quantity to the side which will be removed
                var originalQuantity = $("#" + elementName + choiceId).val();
                $("#" + elementName + choiceId).val(Number(originalQuantity) + Number(unselectedQuantity));
                unselectedQuantity = 0;   // only add one time. I use this method is because we cannot out of loop using break.
            }
        });
    }

    disableRestOfChoices($) {
        var choiceElements = $("." + this.divElementIdPrefix).toArray()
        var divElementName = this.divElementIdPrefix;
        var elementName = this.elementIdPrefix;
        choiceElements.forEach(function(choiceElement) {
            var commonFunction = new CommonFunction();
            var choiceId = commonFunction.retrieveId(divElementName, choiceElement.id);
            if (Number($("#" + elementName + choiceId).val()) == 0) {
                $("#" + divElementName + choiceId).prop('disabled', true);
                $("#" + divElementName + choiceId).css('background-color', 'lightgray');
            }
        });
    }
    /* Max Three ******************** End */    
}

class CommonFunction {
    retrieveId(elementClass, elementClassId) {
        // quantityMinus1 is elementClassId, quantityMinus is elementClass
        var lengthClass = elementClass.length;
        var lengthClassId = elementClassId.length;
        var id = elementClassId.substr(lengthClass, (lengthClassId-lengthClass));
        return id;
    }
}

if (typeof module !== 'undefined') module.exports = { 
    ChoiceSelection,
    CommonFunction,
};