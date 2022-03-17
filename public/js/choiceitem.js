/* Side Start */
//function checkSelectedSideItem(sideId, $, choiceSelectionObj, enableAddToCartButtonForCombos) {
function checkSelectedSideItem(sideId, $, enableAddToCartButtonForCombos) {
    if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
        sideMaxQuantity = $("#sideMaxQuantity").val();
        /*if (sideMaxQuantity == 1) { // Using sideSelected element to display Half/One Selected
            choiceSelection = new ChoiceSelection("side", "sideSelected", "choiceItemSide", sideId, 0, sideMaxQuantity);
            choiceSelection.showSelected($);
        } else {    // Using sideQuantity element to display the number of sides selected
            choiceSelection = new ChoiceSelection("side", "sideQuantity", "choiceItemSide", sideId, 0, sideMaxQuantity);
            choiceSelection.showSelected($);
        }*/
        this.showSelectedFromChoiceItem($, "side", sideId, sideMaxQuantity);
        
        entreeMaxQuantity = $("#entreeMaxQuantity").val();
        drinkMaxQuantity = $("#drinkMaxQuantity").val();
        enableAddToCartButtonForCombos(sideMaxQuantity, entreeMaxQuantity, drinkMaxQuantity, $);
    }    
}
/* Side End */
//constructor(category, elementIdPrefix, divElementIdPrefix, id, quantity, maxQuantity) {
function showSelectedFromChoiceItem($, category, id, maxQuantity) {
    if (maxQuantity == 1) { // Using (category)+Selected element to display Half/One Selected for Side, One Selected for Entree
        const choiceSelection = new ChoiceSelection(category, category + "Selected", "choiceItem" + category[0].toUpperCase() + category.substring(1), id, 0, maxQuantity);
        choiceSelection.showSelected($);
        //console.log("Goooooooooooooooooooooooooooooooo");
    } else {    // Using (category)+Quantity element to display the number of sides/entrees selected
        const choiceSelection = new ChoiceSelection(category, category + "Quantity", "choiceItem" + category[0].toUpperCase() + category.substring(1), id, 0, maxQuantity);
        choiceSelection.showSelected($);
    }
}


/* Entree Start */
function checkSelectedEntreeItem(entreeId, $, enableAddToCartButtonForCombos) {
    if (($("#sideMaxQuantity").val() != undefined) && ($("#entreeMaxQuantity").val() != undefined)) {
        entreeMaxQuantity = $("#entreeMaxQuantity").val();
        /*if (entreeMaxQuantity == 1) {   // Using entreeSelected to dispaly One Selected
            choiceSelection = new ChoiceSelection("entree", "entreeSelected", "choiceItemEntree", entreeId, 0, entreeMaxQuantity);
            choiceSelection.showSelected($);
        } else {    // Using entreeQuantity to display the number of entrees selected
            choiceSelection = new ChoiceSelection("entree", "entreeQuantity", "choiceItemEntree", entreeId, 0, entreeMaxQuantity);
            choiceSelection.showSelected($);
        }*/
        this.showSelectedFromChoiceItem($, "entree", entreeId, entreeMaxQuantity);
   
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
        showSelectedFromChoiceItem,
    }
};