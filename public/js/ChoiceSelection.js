class ChoiceSelection {
    constructor(category, elementIdPrefix, divElementIdPrefix, id, quantity, maxQuantity) {
        // if maxQuantity = 1, then
        //  elementIdPrefix is sideSelected or entreeSelected. 
        //  divElementIdPrefix is choiceItemSide or choiceItemEntree

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

    showSelected() {
        //var count = $('.' + this.elementIdPrefix).length;
        if (this.maxQuantity == 1) {
            if (this.category == 'side') {
                this.handleMaxOneSideSelected();
            } else if (this.category == 'entree') {
                this.handleMaxOneEntreeSelected();
            }
        } else if (this.maxQuantity == 3) {
            this.handleThreeSelected();
        }
        
    }

    /* Max One ******************** Start */
    handleMaxOneSideSelected() {
        if ($("#" + this.elementIdPrefix + this.id).text() == "One Selected") {
            $("#" + this.elementIdPrefix + this.id).text("");
            $("#" + this.divElementIdPrefix + this.id).css("border","3px solid lightgray");
        } else if ($("#" + this.elementIdPrefix + this.id).text() == "") {
            if (this.findOneSelectedSideAndChangeToHalf()) {
                $("#" + this.elementIdPrefix + this.id).text("Half Selected");
                $("#" + this.divElementIdPrefix + this.id).css("border","5px solid red");
                this.disableRestOfSideChoices();
            } else {
                $("#" + this.elementIdPrefix + this.id).text("One Selected");
                $("#" + this.divElementIdPrefix + this.id).css("border","5px solid red");
            }
        } else if ($("#" + this.elementIdPrefix + this.id).text() == "Half Selected") {
            $("#" + this.elementIdPrefix + this.id).text("");
            $("#" + this.divElementIdPrefix + this.id).css("border","3px solid lightgray");
            this.changeFromHalfToOneSelectedSide();
            this.enableAllSideChoices();
        }

        /*if ($("#sideSelected" + sideId).text() == "One Selected") {
            $("#sideSelected" + sideId).text("");
            $("#choiceItemSide" + sideId).css("border","3px solid lightgray");
        } else if ($("#sideSelected" + sideId).text() == "") {
            if (findOneSelectedSideAndChangeToHalf()) {
                $("#sideSelected" + sideId).text("Half Selected");
                $("#choiceItemSide" + sideId).css("border","5px solid red");
                disableRestOfSideChoices();
            } else {
                $("#sideSelected" + sideId).text("One Selected");
                $("#choiceItemSide" + sideId).css("border","5px solid red");
            }
        } else if ($("#sideSelected" + sideId).text() == "Half Selected") {
            $("#sideSelected" + sideId).text("");
            $("#choiceItemSide" + sideId).css("border","3px solid lightgray");
            changeFromHalfToOneSelectedSide();
            enableAllSideChoices();
        }*/
    }

    handleMaxOneEntreeSelected() {
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

    findOneSelectedSideAndChangeToHalf() {
        var isOneSelected = false;
        var sideElements = $("." + this.divElementIdPrefix).toArray();
        var divElementName = this.divElementIdPrefix;
        var elementName = this.elementIdPrefix;
        sideElements.forEach(function(sideElement) {
            var sideId = retrieveId(divElementName, sideElement.id);
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
                var sideId = retrieveId("choiceItemSide", sideElement.id);
                if ($("#sideSelected" + sideId).text() == "One Selected") {
                    $("#sideSelected" + sideId).text("Half Selected");
                    isOneSelected = true;
                }
            });
            return isOneSelected;
        }*/

    enableAllSideChoices() {
        $('.' + this.divElementIdPrefix).prop('disabled', false);
        $('.' + this.divElementIdPrefix).css('background-color', 'white');
    }

    changeFromHalfToOneSelectedSide() {
        var sideElements = $("." + this.divElementIdPrefix).toArray();
        var divElementName = this.divElementIdPrefix;
        var elementName = this.elementIdPrefix;
        sideElements.forEach(function(sideElement) {
            var sideId = retrieveId(divElementName, sideElement.id);
            if ($("#" + elementName + sideId).text() == "Half Selected") {
                $("#" + elementName + sideId).text("One Selected");
            }
        });

        /*var sideElements = $(".choiceItemSide").toArray()
        sideElements.forEach(function(sideElement) {
            var sideId = retrieveId("choiceItemSide", sideElement.id);
            if ($("#sideSelected" + sideId).text() == "Half Selected") {
                $("#sideSelected" + sideId).text("One Selected");
            }
        });*/
    }   

    disableRestOfSideChoices() {
        var sideElements = $("." + this.divElementIdPrefix).toArray()
        var divElementName = this.divElementIdPrefix;
        var elementName = this.elementIdPrefix;
        sideElements.forEach(function(sideElement) {
            var sideId = retrieveId(divElementName, sideElement.id);
            if ($("#" + elementName + sideId).text() != "Half Selected") {
                $("#" + divElementName + sideId).prop('disabled', true);
                $("#" + divElementName + sideId).css('background-color', 'lightgray');
            }
        });
    }
    /* Max One ******************** End */



    /* Max Three ******************** Start */
    // if maxQuantity > 2, then
        // elementIdPrefix is sideQuantity or entreeQuantity (this indicates the quantity, sideQuantityIncrementDiv/entreeQuantityIncrementDiv, sideQuantityPlus/entreeQuantityPlus, sideQuantityMinus/entreeQuantityMinus)
        // divElementIdPrefix is choiceItemSide or choiceItemEntree
    handleThreeSelected() {
        if ($("#" + this.elementIdPrefix + this.id).val() == 0) {
            // None of side is selected
            if (this.isAllZeroQuantity()) {
                $("#" + this.incrementDiv + this.id).css("display", "block");
                $("#" + this.elementIdPrefix + this.id).val(sideMaxQuantity);
                $("#" + this.divElementIdPrefix + this.id).css("border", "5px solid red");
            } else if (this.doesOneSideHaveThree()) {  // One of side is selected == 3
                $("#" + this.incrementDiv + this.id).css("display", "block");
                $("#" + this.elementIdPrefix + this.id).val(1);
                $("#" + this.divElementIdPrefix + this.id).css("border", "5px solid red");
            } else if (this.doesOneSideHaveTwoAndOneSideHaveOne()) {    // two of side are selected, one is 2, one is 1
                $("#" + this.incrementDiv + this.id).css("display", "block");
                $("#" + this.elementIdPrefix + this.id).val(1);
                $("#" + this.divElementIdPrefix + this.id).css("border", "5px solid red");
            }
        } else if ($("#sideQuantity" + this.id).val() != 0) {
            var sideQuantity = $("#" + this.elementIdPrefix + this.id).val();
            if (sideQuantity != 3) {
                this.addSideQuantityToOther(sideQuantity, this.id);
            } 
            $("#" + this.incrementDiv + this.id).css("display", "none");    
            $("#" + this.elementIdPrefix + this.id).val(0);   
            $("#" + this.divElementIdPrefix + this.id).css("border", "3px solid lightgray");

        }

        /*if ($("#sideQuantity" + this.id).val() == 0) {
            // None of side is selected
            if (this.isAllZeroQuantity()) {
                $("#sideQuantityIncrementDiv" + this.id).css("display", "block");
                $("#sideQuantity" + this.id).val(sideMaxQuantity);
                $("#choiceItemSide" + this.id).css("border", "5px solid red");
            } else if (this.doesOneSideHaveThree()) {  // One of side is selected == 3
                $("#sideQuantityIncrementDiv" + this.id).css("display", "block");
                $("#sideQuantity" + this.id).val(1);
                $("#choiceItemSide" + this.id).css("border", "5px solid red");
            } else if (this.doesOneSideHaveTwoAndOneSideHaveOne()) {    // two of side are selected, one is 2, one is 1
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

    isAllZeroQuantity() {
        var isAllZero = true;
        var elementName = this.elementIdPrefix; // It does not work this.elementIdPrefix in the forEach loop
        var sideElements = $("." + this.elementIdPrefix).toArray();
        sideElements.forEach(function(sideElement) {
            var sideId = retrieveId(elementName, sideElement.id);
            if ($("#" + elementName + sideId).val() != 0) {
                isAllZero = false;
            }
        });
        return isAllZero;
    }

    doesOneSideHaveThree() {
        var exists = false;
        var elementName = this.elementIdPrefix; // It does not work this.elementIdPrefix in the forEach loop
        var sideElements = $("." + this.elementIdPrefix).toArray();
        sideElements.forEach(function(sideElement) {
            var sideId = retrieveId(elementName, sideElement.id);
            if ($("#" + elementName + sideId).val() == 3) {
                $("#" + elementName + sideId).val(2);
                exists = true;
            }
        });
        return exists;
    }

    doesOneSideHaveTwoAndOneSideHaveOne() {
        var oneExists = false;
        var twoExists = false;
        var sideIdOfTwo = 0;
        var elementName = this.elementIdPrefix; // It does not work this.elementIdPrefix in the forEach loop
        var sideElements = $("." + this.elementIdPrefix).toArray();
        sideElements.forEach(function(sideElement) {
            var sideId = retrieveId(elementName, sideElement.id);
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

    addSideQuantityToOther(sideQuantity, currentId) {
        var unselectedQuantity = sideQuantity;
        var elementName = this.elementIdPrefix; // It does not work this.elementIdPrefix in the forEach loop
        var sideElements = $("." + this.elementIdPrefix).toArray();
        sideElements.forEach(function(sideElement) {
            var sideId = retrieveId(elementName, sideElement.id);
            if (($("#" + elementName + sideId).val() != 0) && (sideId != currentId)) {   // (sideId != currentId) is not adding the quantity to the side which will be removed
                var originalQuantity = $("#" + elementName + sideId).val();
                $("#" + elementName + sideId).val(Number(originalQuantity) + Number(unselectedQuantity));
                unselectedQuantity = 0;   // only add one time. I use this method is because we cannot out of loop using break.
            }
        });
    }
    /* Max Three ******************** End */    
}    