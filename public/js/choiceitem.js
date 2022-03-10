/* Side Start */
function checkSelectedSideItem(sideId) {
    if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
        sideMaxQuantity = $("#sideMaxQuantity").val();
        if (sideMaxQuantity == 1) { // Using sideSelected element to display Half/One Selected
            choiceSelection = new ChoiceSelection("side", "sideSelected", "choiceItemSide", sideId, 0, sideMaxQuantity);
            choiceSelection.showSelected($);
        } else {    // Using sideQuantity element to display the number of sides selected
            choiceSelection = new ChoiceSelection("side", "sideQuantity", "choiceItemSide", sideId, 0, sideMaxQuantity);
            choiceSelection.showSelected($);
        }
        
        entreeMaxQuantity = $("#entreeMaxQuantity").val();
        drinkMaxQuantity = $("#drinkMaxQuantity").val();
        enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity, $);
    }    
}
/* Side End */


/* Entree Start */
function checkSelectedEntreeItem(entreeId) {
    if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
        entreeMaxQuantity = $("#entreeMaxQuantity").val();
        if (entreeMaxQuantity == 1) {   // Using entreeSelected to dispaly One Selected
            choiceSelection = new ChoiceSelection("entree", "entreeSelected", "choiceItemEntree", entreeId, 0, entreeMaxQuantity);
            choiceSelection.showSelected($);
        } else {    // Using entreeQuantity to display the number of entrees selected
            choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", entreeId, 0, entreeMaxQuantity);
            choiceSelection.showSelected($);
        }
   
        sideMaxQuantity = $("#sideMaxQuantity").val();
        drinkMaxQuantity = $("#drinkMaxQuantity").val();
        enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity, $);
    }
}
/* Entree End */

if (typeof module !== 'undefined'){
    module.exports = {
        checkSelectedSideItem,
        checkSelectedEntreeItem,
    }
};