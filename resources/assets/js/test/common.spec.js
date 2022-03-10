//const { fn } = require('jquery');
const commonFunctions = require('../../../../public/js/common');
const { ChoiceSelection } = require('../../../../public/js/ChoiceSelection');
//const commonFunctionsForMock = require('../../../../public/js/common');
//const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
//import {retrieveId} from '../../../../public/js/common';

describe('retrieveId Function', () => {
  test('Retrieve Id from class name and id name of element', () => {
    // quantityMinus1 is elementClassId, quantityMinus is elementClass
    const id = commonFunctions.retrieveId('quantityMinus', 'quantityMinus1');
    expect(id).toBe('1');
  });
});

describe('retrieveProductIdForCartButtons Function', () => {
  test('Retrieve ProductId For Cart Buttons', () => {
    // quantityMinus1AND2 -- 1 is the serialNumber, 2 is the productId
    const id = commonFunctions.retrieveProductIdForCartButtons('quantityMinus', 'quantityMinus1AND2');
    expect(id).toBe('2');
  });
});

describe('retrieveSerialNumberForCartButtons Function', () => {
  test('Retrieve Serial Number For Cart Buttons', () => {
     // quantityMinus1AND2 -- 1 is the serialNumber, 2 is the productId
     const serialNumber =  commonFunctions.retrieveSerialNumberForCartButtons('quantityMinus', 'quantityMinus1AND2');
     expect(serialNumber).toBe('1');
  });
});

describe('loadPriceDetailElements Function', () => {
  test('Load Price Detail Elements - Not Empty', () => {
     var priceDetail = {'totalQuantity': 1, 'totalPrice': 4.59, 'tax': 0.38, 'total': 4.97};
     var html = commonFunctions.loadPriceDetailElements(priceDetail);
     expect(html).toMatch('4.59');
     expect(html).toMatch('0.38');
     expect(html).toMatch('4.97');
     expect(html).toMatchInlineSnapshot(`"<h5>Price Detail</h5><hr><div class=\\"row px-5\\"><div class=\\"col-md-6 text-start\\"><h5>Price (1 items)</h5><h5>Tax</h5><hr><h4>Order Total</h4></div><div class=\\"col-md-6 text-end\\"><h5>$4.59</h5><h5>$0.38</h5><hr><h4>$4.97</h4></div></div><br><div class=\\"text-center\\"><button style=\\"width: 30%\\" type=\\"button\\" class=\\"btn btn-primary\\" id=\\"checkout\\" >Checkout</button><button style=\\"width: 30%\\" type=\\"button\\" class=\\"btn btn-danger\\" id=\\"emptycart\\">Empty Cart</button></div>"`);
  });

  test('load Price Detail Elements - Empty and Checkout Button is disabled', () => {
    var priceDetail = {'totalQuantity': 0, 'totalPrice': 0, 'tax': 0, 'total': 0};
    var html = commonFunctions.loadPriceDetailElements(priceDetail);
    expect(html).toMatch('0');
    expect(html).toMatch('disabled');
    expect(html).toMatchInlineSnapshot(`"<h5>Price Detail</h5><hr><div class=\\"row px-5\\"><div class=\\"col-md-6 text-start\\"><h5>Price (0 items)</h5><h5>Tax</h5><hr><h4>Order Total</h4></div><div class=\\"col-md-6 text-end\\"><h5>$0</h5><h5>$0</h5><hr><h4>$0</h4></div></div><br><div class=\\"text-center\\"><button style=\\"width: 30%\\" type=\\"button\\" class=\\"btn btn-primary\\" id=\\"checkout\\" disabled>Checkout</button><button style=\\"width: 30%\\" type=\\"button\\" class=\\"btn btn-danger\\" id=\\"emptycart\\">Empty Cart</button></div>"`);
 });
});

describe('loadCartCountElements Function', () => {
  test('Load Cart Count Elements', () => {
    var html = commonFunctions.loadCartCountElements(12);
    expect(html).toMatch('<span id="cart_count" class="text-warning bg-light">12</span>');
    expect(html).toMatchInlineSnapshot(`"<span id=\\"cart_count\\" class=\\"text-warning bg-light\\">12</span>"`);
 });
});

describe('loadCheckoutMenuElement Function', () => {
  test('Load Checkout Menu Element - With Quantity', () => {
    var html = commonFunctions.loadCheckoutMenuElement(12);
    expect(html).toMatch('<a class=\"nav-link active\" aria-current=\"page\" href=/checkout>Checkout</a>');
    expect(html).toMatchInlineSnapshot(`"<a class=\\"nav-link active\\" aria-current=\\"page\\" href=/checkout>Checkout</a>"`);
  });

  test('Load Checkout Menu Element - Without Quantity - Checkout menu is disabled', () => {
    var html = commonFunctions.loadCheckoutMenuElement(0);
    expect(html).toMatch('<a class=\"nav-link \" aria-current=\"page\" href=javascript:void(0);>Checkout</a>');
    expect(html).toMatchInlineSnapshot(`"<a class=\\"nav-link \\" aria-current=\\"page\\" href=javascript:void(0);>Checkout</a>"`);
  });
});

describe('loadOrderListElements Function', () => {
  test('Load Order List Elements with Appetize', () => {
    var items = [];
    var subItems = [];
    var productItem = {"id":1, "name":"Egg Roll(5)", "price":4.59, "description":"5 egg rolls", "gallery":"EggRoll.jpg", "menu_id":1};
    var totalPricePerProductItem = 4.59;
    items[1] = {'productItem': productItem, 'quantity':1, 'subItems':subItems, 'totalPricePerProductItem':totalPricePerProductItem};
    var html = commonFunctions.loadOrderListElements(items);
    expect(html).toMatch('4.59');
    expect(html).toMatchInlineSnapshot(`"<form action=\\"/cart\\" method=\\"get\\" class=\\"cart-items\\"><div class=\\"border rounded\\"><div class=\\"row bg-white\\"><div class=\\"col-md-3\\"><img src=\\"\\\\images\\\\EggRoll.jpg\\" style=\\"width: 100%\\"></div><div class=\\"col-md-6\\"><h5 class=\\"pt-2\\">Egg Roll(5) <small> (5 egg rolls)</small> </h5><h5><small style=\\"color:red\\"></small> </h5><h5 class=\\"pt-1\\">$4.59</h5><div class=\\"pb-1\\"><button type=\\"submit\\" class=\\"btn btn-warning edit\\" id=\\"edit1AND1\\" data-bs-toggle=\\"modal\\" data-bs-target=\\"#editModal\\">Edit</button><button type=\\"button\\" class=\\"btn btn-danger mx-2 remove\\" id=\\"remove1AND1\\">Remove</button></div></div><div class=\\"col-md-3\\"><div class=\\"py-5\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForCart\\" id=\\"quantityMinusForCart1AND1\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center\\" value=\\"1\\" id=\\"quantityForCart1AND1\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForCart\\" id=\\"quantityPlusForCart1AND1\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div></form>"`);
  });

  describe('retrieveSummary Function', () => {
    test('Load Order List Elements with Kids Meal -- for calling retrieveSummary', () => {    
      var items = [];
      var subItems = [];
      var sideItem = {"id":1, "name":"Fried Rice", "description":"Fried rice with some vegetables and soy source","gallery":"FriedRice.jpg"};
      var sideArray = {"category":"Side", "item":sideItem, "quantity":0.5};
      var entreeItem = {"id":1, "name":"BBQ Chicken", "description":"BBQ chicken entree", "category":"Chicken", "gallery":"BBQChicken.jpg"};
      var entreeArray = {"category":"Entree", "item":entreeItem, "quantity":1};
      var drinkItem = {"id":1, "name":"Small Drink", "description":"Small fountain drink for kid's meal", "price":0, "gallery":"SoftDrinkFountain.jpg", "tablename":"fountains"};
      var selectDrink = {"id":1, "name":"Coke"};
      var drinkArray = {"category":"Drink", "item":drinkItem, "quantity":1, "selectDrink":selectDrink};
      subItems.push(sideArray);
      subItems.push(entreeArray);
      subItems.push(drinkArray);
      var productItem = {"id":16, "name":"Kid's Meal", "price":4.99, "description":"One small drink, one side and one entree", "gallery":"KidsMeal.jpg", "menu_id":3, "category":""};
      var totalPricePerProductItem = 0;
      items[1] = {'productItem': productItem, 'quantity':1, 'subItems':subItems, 'totalPricePerProductItem':totalPricePerProductItem};
      var html = commonFunctions.loadOrderListElements(items);
      expect(html).toMatch('4.99');
      expect(html).toMatchInlineSnapshot(`"<form action=\\"/cart\\" method=\\"get\\" class=\\"cart-items\\"><div class=\\"border rounded\\"><div class=\\"row bg-white\\"><div class=\\"col-md-3\\"><img src=\\"\\\\images\\\\KidsMeal.jpg\\" style=\\"width: 100%\\"></div><div class=\\"col-md-6\\"><h5 class=\\"pt-2\\">Kid's Meal <small> (One small drink, one side and one entree)</small> </h5><h5><small style=\\"color:red\\">Side: Fried Rice(1/2) Entree: BBQ Chicken(1) Drink: Small Drink - Coke</small> </h5><h5 class=\\"pt-1\\">$4.99</h5><div class=\\"pb-1\\"><button type=\\"submit\\" class=\\"btn btn-warning edit\\" id=\\"edit1AND16\\" data-bs-toggle=\\"modal\\" data-bs-target=\\"#editModal\\">Edit</button><button type=\\"button\\" class=\\"btn btn-danger mx-2 remove\\" id=\\"remove1AND16\\">Remove</button></div></div><div class=\\"col-md-3\\"><div class=\\"py-5\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForCart\\" id=\\"quantityMinusForCart1AND16\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center\\" value=\\"1\\" id=\\"quantityForCart1AND16\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForCart\\" id=\\"quantityPlusForCart1AND16\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div></form>"`);
    });

    test('Load Order List Elements with Kids Meal -- for calling retrieveSummary -- quantity 0.5 and drink extra charge', () => {     
      var items = [];
      var subItems = [];
      var sideItem1 = {"id":1, "name":"Fried Rice", "description":"Fried rice with some vegetables and soy source","gallery":"FriedRice.jpg"};
      var sideArray1 = {"category":"Side", "item":sideItem1, "quantity":0.5};
      var sideItem2 = {"id":2, "name":"Chow Mein", "description":"Chow mein with some vegetables","gallery":"ChowMein.jpg"};
      var sideArray2 = {"category":"Side", "item":sideItem2, "quantity":0.5};
      var entreeItem = {"id":1, "name":"BBQ Chicken", "description":"BBQ chicken entree", "category":"Chicken", "gallery":"BBQChicken.jpg"};
      var entreeArray = {"category":"Entree", "item":entreeItem, "quantity":1};
      var drinkItem = {"id":2, "name":"Bottle Water", "description":"Bottle water for kid's meal", "price":0.75, "gallery":"BottleWater.jpg", "tablename":""};
      var drinkArray = {"category":"Drink", "item":drinkItem, "quantity":1};
      subItems.push(sideArray1);
      subItems.push(sideArray2);
      subItems.push(entreeArray);
      subItems.push(drinkArray);
      var productItem = {"id":16, "name":"Kid's Meal", "price":4.99, "description":"One small drink, one side and one entree", "gallery":"KidsMeal.jpg", "menu_id":3, "category":""};
      var totalPricePerProductItem = 5.74;
      items[1] = {'productItem': productItem, 'quantity':1, 'subItems':subItems, 'totalPricePerProductItem':totalPricePerProductItem};
      var html = commonFunctions.loadOrderListElements(items);
      expect(html).toMatch('5.74');
      expect(html).toMatchInlineSnapshot(`"<form action=\\"/cart\\" method=\\"get\\" class=\\"cart-items\\"><div class=\\"border rounded\\"><div class=\\"row bg-white\\"><div class=\\"col-md-3\\"><img src=\\"\\\\images\\\\KidsMeal.jpg\\" style=\\"width: 100%\\"></div><div class=\\"col-md-6\\"><h5 class=\\"pt-2\\">Kid's Meal <small> (One small drink, one side and one entree)</small> </h5><h5><small style=\\"color:red\\">Side: Fried Rice(1/2) Chow Mein(1/2) Entree: BBQ Chicken(1) Drink: Bottle Water - extra charge: $0.75</small> </h5><h5 class=\\"pt-1\\">$4.99 + $0.75 = $5.74</h5><div class=\\"pb-1\\"><button type=\\"submit\\" class=\\"btn btn-warning edit\\" id=\\"edit1AND16\\" data-bs-toggle=\\"modal\\" data-bs-target=\\"#editModal\\">Edit</button><button type=\\"button\\" class=\\"btn btn-danger mx-2 remove\\" id=\\"remove1AND16\\">Remove</button></div></div><div class=\\"col-md-3\\"><div class=\\"py-5\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForCart\\" id=\\"quantityMinusForCart1AND16\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center\\" value=\\"1\\" id=\\"quantityForCart1AND16\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForCart\\" id=\\"quantityPlusForCart1AND16\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div></form>"`);
    });

    test('Load Order List Elements with Side only -- for calling retrieveSummary and retrieveImageFromSubItems -- for category "Side"', () => {      
      var items = [];
      var subItems = [];
      var sideItem = {"id":1, "name":"Fried Rice", "description":"Fried rice with some vegetables and soy source","gallery":"FriedRice.jpg"};
      var sideArray = {"category":"Side", "item":sideItem, "quantity":1};
      subItems.push(sideArray);
      var productItem = {"id":17, "name":"Small Side", "price":2.49, "description":"Small size of side", "gallery":"", "menu_id":4, "category":"Side"};
      var totalPricePerProductItem = 2.49;
      items[1] = {'productItem': productItem, 'quantity':1, 'subItems':subItems, 'totalPricePerProductItem':totalPricePerProductItem};
      var html = commonFunctions.loadOrderListElements(items);
      expect(html).toMatch('2.49');
      expect(html).toMatchInlineSnapshot(`"<form action=\\"/cart\\" method=\\"get\\" class=\\"cart-items\\"><div class=\\"border rounded\\"><div class=\\"row bg-white\\"><div class=\\"col-md-3\\"><img src=\\"\\\\images\\\\FriedRice.jpg\\" style=\\"width: 100%\\"></div><div class=\\"col-md-6\\"><h5 class=\\"pt-2\\">Small Side <small> (Small size of side)</small> </h5><h5><small style=\\"color:red\\">Side: Fried Rice </small> </h5><h5 class=\\"pt-1\\">$2.49</h5><div class=\\"pb-1\\"><button type=\\"submit\\" class=\\"btn btn-warning edit\\" id=\\"edit1AND17\\" data-bs-toggle=\\"modal\\" data-bs-target=\\"#editModal\\">Edit</button><button type=\\"button\\" class=\\"btn btn-danger mx-2 remove\\" id=\\"remove1AND17\\">Remove</button></div></div><div class=\\"col-md-3\\"><div class=\\"py-5\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForCart\\" id=\\"quantityMinusForCart1AND17\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center\\" value=\\"1\\" id=\\"quantityForCart1AND17\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForCart\\" id=\\"quantityPlusForCart1AND17\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div></form>"`);
    });

    test('Load Order List Elements with Entree only -- for calling retrieveSummary -- for category "Entree"', () => {      
      var items = [];
      var subItems = [];
      var entreeItem = {"id":1, "name":"BBQ Chicken", "description": "BBQ Chicken entree", "category":"Chicken", "gallery":"BBQChicken.jpg"};
      var entreeArray = {"category":"Entree", "item":entreeItem, "quantity":1};
      subItems.push(entreeArray);
      var productItem = {"id":20, "name":"Small Chicken", "price":5.49, "description":"Small size of chicken entree", "gallery":"", "menu_id":4, "category":"Entree"};
      var totalPricePerProductItem = 5.49;
      items[1] = {'productItem': productItem, 'quantity':1, 'subItems':subItems, 'totalPricePerProductItem':totalPricePerProductItem};
      var html = commonFunctions.loadOrderListElements(items);
      expect(html).toMatch('5.49');
      expect(html).toMatchInlineSnapshot(`"<form action=\\"/cart\\" method=\\"get\\" class=\\"cart-items\\"><div class=\\"border rounded\\"><div class=\\"row bg-white\\"><div class=\\"col-md-3\\"><img src=\\"\\\\images\\\\BBQChicken.jpg\\" style=\\"width: 100%\\"></div><div class=\\"col-md-6\\"><h5 class=\\"pt-2\\">Small Chicken <small> (Small size of chicken entree)</small> </h5><h5><small style=\\"color:red\\">Entree: BBQ Chicken </small> </h5><h5 class=\\"pt-1\\">$5.49</h5><div class=\\"pb-1\\"><button type=\\"submit\\" class=\\"btn btn-warning edit\\" id=\\"edit1AND20\\" data-bs-toggle=\\"modal\\" data-bs-target=\\"#editModal\\">Edit</button><button type=\\"button\\" class=\\"btn btn-danger mx-2 remove\\" id=\\"remove1AND20\\">Remove</button></div></div><div class=\\"col-md-3\\"><div class=\\"py-5\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForCart\\" id=\\"quantityMinusForCart1AND20\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center\\" value=\\"1\\" id=\\"quantityForCart1AND20\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForCart\\" id=\\"quantityPlusForCart1AND20\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div></form>"`);
    });

    test('Load Order List Elements with Drink only -- for calling retrieveSummary -- for category "DrinkOnly"', () => {      
      var items = [];
      var subItems = [];
      var drinkItem = {"id":3, "name":"Canned Drink", "description":"A canned soft drink","gallery":"SoftDrinkCan.jpg", "tablename":"cans"};
      var selectDrink = {"id":1, "name":"Coke"};
      var drinkArray = {"category":"DrinkOnly", "item":drinkItem, "quantity":1, "selectDrink":selectDrink};
      subItems.push(drinkArray);
      var productItem = {"id":6, "name":"Canned Soft Drink", "price":1.25, "description":"Soft drink canned", "gallery":"", "menu_id":2, "category":"Canned Drink"};
      var totalPricePerProductItem = 1.25;
      items[1] = {'productItem': productItem, 'quantity':1, 'subItems':subItems, 'totalPricePerProductItem':totalPricePerProductItem};
      var html = commonFunctions.loadOrderListElements(items);
      expect(html).toMatch('1.25');
      expect(html).toMatchInlineSnapshot(`"<form action=\\"/cart\\" method=\\"get\\" class=\\"cart-items\\"><div class=\\"border rounded\\"><div class=\\"row bg-white\\"><div class=\\"col-md-3\\"><img src=\\"\\\\images\\\\SoftDrinkCan.jpg\\" style=\\"width: 100%\\"></div><div class=\\"col-md-6\\"><h5 class=\\"pt-2\\">Canned Soft Drink <small> (Soft drink canned)</small> </h5><h5><small style=\\"color:red\\">Flavor: Coke</small> </h5><h5 class=\\"pt-1\\">$1.25</h5><div class=\\"pb-1\\"><button type=\\"submit\\" class=\\"btn btn-warning edit\\" id=\\"edit1AND6\\" data-bs-toggle=\\"modal\\" data-bs-target=\\"#editModal\\">Edit</button><button type=\\"button\\" class=\\"btn btn-danger mx-2 remove\\" id=\\"remove1AND6\\">Remove</button></div></div><div class=\\"col-md-3\\"><div class=\\"py-5\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForCart\\" id=\\"quantityMinusForCart1AND6\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center\\" value=\\"1\\" id=\\"quantityForCart1AND6\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForCart\\" id=\\"quantityPlusForCart1AND6\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div></form>"`);
    });
  });
});

describe('orderListElement Function', () => {
  // Included in above: loadOrderListElements Function
});

describe('retrieveSummary Function', () => {
  // Included in above: loadOrderListElements Function
  // But below is for partial testing
  test('Retrieve Summary -- For DrinkOnly -- subItems key hasOwnProperty of selectDrink is FALSE', () => {
    var subItems = [];
    var drinkItem = {"id":2, "name":"Bottle Water", "description":"Bottle of water", "gallery":"BottleWater.jpg", "tablename":""};
    var drinkArray = {"category":"DrinkOnly", "item":drinkItem, "quantity":1};
    subItems.push(drinkArray);
    var summary = commonFunctions.retrieveSummary(subItems);
    expect(summary).toBe("");
  });
});

describe('retrieveExtraCharge Function', () => {
  // Included in above: loadOrderListElements Function
});

describe('retrieveImageFromSubItems Function', () => {
  // Included in above: loadOrderListElements Function
  // But below is for partial testing
  test('Retrieve Image From SubItems -- subItems is null', () => {
    var image = commonFunctions.retrieveImageFromSubItems(null);
    expect(image).toBe("");
  });
});

describe('enableAddToCartButtonForCombos Function', () => {
  /*afterEach(() => {
    jest.clearAllMocks();
  })*/

  test('Enable Add To Cart Button For Combos -- Quantity == 0', () => {
    document.body.innerHTML = 
      '<input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity1" disabled style="margin: 0px 10px">' +
      '<button type="button" class="btn bg-light border addToCartForCombo" id="addToCartForCombo1">Add to Cart</button>';

      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
      //common.retrieveTotalSideQuantity = jest.fn().mockReturnValue(1);
      const totalSideQuantity = jest.spyOn(commonFunctions, 'retrieveTotalSideQuantity').mockReturnValue(1);
      commonFunctions.enableAddToCartButtonForCombos(1, 1, 1, $);
      var buttonDisabled = $(".addToCartForCombo").is(":disabled");
      var color = $(".addToCartForCombo").css('color');
      expect(buttonDisabled).toBeTruthy();
      expect(color).toBe('gray');
      totalSideQuantity.mockRestore();
  });

  test('Enable Add To Cart Button For Combos -- drinkMaxQuantity is undefined and Quantity != 0', () => {
    document.body.innerHTML = 
      '<input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity1" disabled style="margin: 0px 10px">' +
      '<button type="button" class="btn bg-light border addToCartForCombo" id="addToCartForCombo1">Add to Cart</button>' +
      '<button type="button" class="btn btn-primary updateCart" id="updateCart1AND1">Update</button>';

      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');

      /* NOTE: In order to make the jest.spyOn or jest.fn() works for retrieveTotalSideQuantity, retrieveTotalEntreeQuantity, retrieveToDrinkQuantity,
                I added "this." in front of them in common.js file
                But if I add "this." in front of retrieveId, the test will show the error: TypeError: this.retrieveId is not a function
                Therefore, I decide to take out the "this." in front of retrieveId in the common.spec.js file*/
      /******** The reason I use jest.spyOn is that jest.fn() cannot be restored back the mock. It will affect the next test. */
      //common.retrieveTotalSideQuantity = jest.fn().mockReturnValue(2);
      //common.retrieveTotalEntreeQuantity = jest.fn().mockReturnValue(1);
      //common.retrieveTotalDrinkQuantity = jest.fn().mockReturnValue(1);
      const totalSideQuantity = jest.spyOn(commonFunctions, 'retrieveTotalSideQuantity').mockReturnValue(1);
      const totalEntreeQuantity = jest.spyOn(commonFunctions, 'retrieveTotalEntreeQuantity').mockReturnValue(1);
      const totalDrinkQuantity = jest.spyOn(commonFunctions, 'retrieveTotalDrinkQuantity').mockReturnValue(1);
      var total = commonFunctions.enableAddToCartButtonForCombos(1,1,undefined, $);
      expect(totalSideQuantity).toBeCalled();
      expect(totalEntreeQuantity).toBeCalled();
      expect(totalDrinkQuantity).not.toBeCalled();
      //expect(common.retrieveTotalSideQuantity).toBeCalled();
      //expect(common.retrieveTotalEntreeQuantity).toHaveBeenCalled();
      //expect(common.retrieveTotalDrinkQuantity).not.toBeCalled();
      //expect(total).toBe(1);
      var buttonDisabled = $(".addToCartForCombo").is(":disabled");
      var color = $(".addToCartForCombo").css('color');
      var updateButtonDisabled = $(".updateCart").is(":disabled");
      expect(buttonDisabled).toBeFalsy();
      expect(color).toBe('red');
      expect(updateButtonDisabled).toBeFalsy();
      totalSideQuantity.mockRestore();
      totalEntreeQuantity.mockRestore();
      totalDrinkQuantity.mockRestore();
  });

  test('Enable Add To Cart Button For Combos -- drinkMaxQuantity is undefined and Quantity != 0 but quantity not matched', () => {
    document.body.innerHTML = 
      '<input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity1" disabled style="margin: 0px 10px">' +
      '<button type="button" class="btn bg-light border addToCartForCombo" id="addToCartForCombo1">Add to Cart</button>' +
      '<button type="button" class="btn btn-primary updateCart" id="updateCart1AND1">Update</button>';

      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');

      const totalSideQuantity = jest.spyOn(commonFunctions, 'retrieveTotalSideQuantity').mockReturnValue(1);
      const totalEntreeQuantity = jest.spyOn(commonFunctions, 'retrieveTotalEntreeQuantity').mockReturnValue(1);
      const totalDrinkQuantity = jest.spyOn(commonFunctions, 'retrieveTotalDrinkQuantity').mockReturnValue(1);
      var total = commonFunctions.enableAddToCartButtonForCombos(2, 2,undefined, $);
      expect(totalSideQuantity).toBeCalled();
      expect(totalEntreeQuantity).toBeCalled();
      expect(totalDrinkQuantity).not.toBeCalled();
  
      var buttonDisabled = $(".addToCartForCombo").is(":disabled");
      var color = $(".addToCartForCombo").css('color');
      var updateButtonDisabled = $(".updateCart").is(":disabled");
      expect(buttonDisabled).toBeTruthy();
      expect(color).toBe('gray');
      expect(updateButtonDisabled).toBeTruthy();
      totalSideQuantity.mockRestore();
      totalEntreeQuantity.mockRestore();
      totalDrinkQuantity.mockRestore();
  });

  test('Enable Add To Cart Button For Combos -- drinkMaxQuantity is NOT undefined and Quantity != 0 and quantity matched', () => {
    document.body.innerHTML = 
      '<input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity1" disabled style="margin: 0px 10px">' +
      '<button type="button" class="btn bg-light border addToCartForCombo" id="addToCartForCombo1">Add to Cart</button>' +
      '<button type="button" class="btn btn-primary updateCart" id="updateCart1AND1">Update</button>';

      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');

      const totalSideQuantity = jest.spyOn(commonFunctions, 'retrieveTotalSideQuantity').mockReturnValue(1);
      const totalEntreeQuantity = jest.spyOn(commonFunctions, 'retrieveTotalEntreeQuantity').mockReturnValue(1);
      const totalDrinkQuantity = jest.spyOn(commonFunctions, 'retrieveTotalDrinkQuantity').mockReturnValue(1);
      var total = commonFunctions.enableAddToCartButtonForCombos(1, 1, 1, $);
      expect(totalSideQuantity).toBeCalled();
      expect(totalEntreeQuantity).toBeCalled();
      expect(totalDrinkQuantity).toBeCalled();
  
      var buttonDisabled = $(".addToCartForCombo").is(":disabled");
      var color = $(".addToCartForCombo").css('color');
      var updateButtonDisabled = $(".updateCart").is(":disabled");
      expect(buttonDisabled).toBeFalsy();
      expect(color).toBe('red');
      expect(updateButtonDisabled).toBeFalsy();
      totalSideQuantity.mockRestore();
      totalEntreeQuantity.mockRestore();
      totalDrinkQuantity.mockRestore();
  });

  test('Enable Add To Cart Button For Combos -- drinkMaxQuantity is NOT undefined and Quantity != 0 and quantity not matched', () => {
    document.body.innerHTML = 
      '<input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity1" disabled style="margin: 0px 10px">' +
      '<button type="button" class="btn bg-light border addToCartForCombo" id="addToCartForCombo1">Add to Cart</button>' +
      '<button type="button" class="btn btn-primary updateCart" id="updateCart1AND1">Update</button>';

      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');

      const totalSideQuantity = jest.spyOn(commonFunctions, 'retrieveTotalSideQuantity').mockReturnValue(1);
      const totalEntreeQuantity = jest.spyOn(commonFunctions, 'retrieveTotalEntreeQuantity').mockReturnValue(1);
      const totalDrinkQuantity = jest.spyOn(commonFunctions, 'retrieveTotalDrinkQuantity').mockReturnValue(1);
      var total = commonFunctions.enableAddToCartButtonForCombos(2, 1, 1, $);
      expect(totalSideQuantity).toBeCalled();
      expect(totalEntreeQuantity).toBeCalled();
      expect(totalDrinkQuantity).toBeCalled();
  
      var buttonDisabled = $(".addToCartForCombo").is(":disabled");
      var color = $(".addToCartForCombo").css('color');
      var updateButtonDisabled = $(".updateCart").is(":disabled");
      expect(buttonDisabled).toBeTruthy();
      expect(color).toBe('gray');
      expect(updateButtonDisabled).toBeTruthy();
      totalSideQuantity.mockRestore();
      totalEntreeQuantity.mockRestore();
      totalDrinkQuantity.mockRestore();
  });

});

describe('retrieveTotalSideQuantity Function', () => {
  /*beforeEach(() => {
    jest.clearAllMocks();
  });
  afterEach(() => {
    jest.clearAllMocks();
    document.body.innerHTML = '';
  });*/

  test('Retrieve Total Side Quantity from menu where users choose the sides they like -- Using sideSelected elements (for Half Selected) not sideQuantity elements', () => {
    document.body.innerHTML = 
      '<div class="choiceItemSide" id="choiceItemSide1">' +
      '<h3 class="sideSelected" id="sideSelected1">Half Selected</h3>' + 
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="0" id="sideQuantity1" disabled>' +
      '<div class="choiceItemSide" id="choiceItemSide2">' +
      '<h3 class="sideSelected" id="sideSelected2">Half Selected</h3>' +
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="0" id="sideQuantity2" disabled>' +
      '<input type="text" id="total" value="22">';

      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
      //const retrieveId111 = jest.spyOn(commonFunctions, 'retrieveId').mockReturnValueOnce(1).mockReturnValueOnce(2);
      //when(retrieveId111).calledWith("choiceItemSide", "choiceItemSide1").mockReturnValue('1'); // Needs to install jest-when

      
      var totalSideQuantity = commonFunctions.retrieveTotalSideQuantity($);
      expect(totalSideQuantity).toEqual(1);
      //console.log("xxxx", document.body.innerHTML);
      //retrieveId111.mockRestore();
  });

  test('Retrieve Total Side Quantity from menu where users choose the sides they like -- Using sideSelected elements (for One Selected) not sideQuantity elements', () => {
    document.body.innerHTML = 
      '<div class="choiceItemSide" id="choiceItemSide1">' +
      '<h3 class="sideSelected" id="sideSelected1">One Selected</h3>' + 
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="0" id="sideQuantity1" disabled>' +
      '<div class="choiceItemSide" id="choiceItemSide2">' +
      '<h3 class="sideSelected" id="sideSelected2"></h3>' +
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="0" id="sideQuantity2" disabled>';

      //const common = require('../../../../public/js/common');
      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
      var totalSideQuantity = commonFunctions.retrieveTotalSideQuantity($);
      expect(totalSideQuantity).toEqual(1);
  });

  test('Retrieve Total Side Quantity from menu where users choose the sides they like -- Using sideQuantity elements (for number) not sideSelected elements', () => {
    document.body.innerHTML = 
      '<div class="choiceItemSide" id="choiceItemSide1">' +
      '<h3 class="sideSelected" id="sideSelected1"></h3>' + 
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="1" id="sideQuantity1" disabled>' +
      '<div class="choiceItemSide" id="choiceItemSide2">' +
      '<h3 class="sideSelected" id="sideSelected2"></h3>' +
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="2" id="sideQuantity2" disabled>';
      
      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
      var totalSideQuantity = commonFunctions.retrieveTotalSideQuantity($);
      expect(totalSideQuantity).toEqual(3);
  });
});

describe('retrieveTotalEntreeQuantity Function', () => {
  test('Retrieve Total Entree Quantity from menu where users choose the entrees they like -- Using entreeSelected elements (for One Selected) not entreeQuantity elements', () => {
    document.body.innerHTML = 
      '<div class="choiceItemEntree" id="choiceItemEntree1">' +
      '<h3 class="entreeSelected" id="entreeSelected1">One Selected</h3>' + 
      '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity1" disabled>' +
      '<div class="choiceItemEntree" id="choiceItemEntree2">' +
      '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
      '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity2" disabled>';

      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
      var totalEntreeQuantity = commonFunctions.retrieveTotalEntreeQuantity($);
      expect(totalEntreeQuantity).toEqual(1);
  });

  test('Retrieve Total Entree Quantity from menu where users choose the entrees they like -- Using entreeQuantity elements (for number) not entreeSelected elements', () => {
    document.body.innerHTML = 
      '<div class="choiceItemEntree" id="choiceItemEntree1">' +
      '<h3 class="entreeSelected" id="entreeSelected1"></h3>' + 
      '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="2" id="entreeQuantity1" disabled>' +
      '<div class="choiceItemEntree" id="choiceItemEntree2">' +
      '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
      '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity2" disabled>';

      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
      var totalEntreeQuantity = commonFunctions.retrieveTotalEntreeQuantity($);
      expect(totalEntreeQuantity).toEqual(3);
  });
});

describe('retrieveTotalDrinkQuantity Function', () => {
  test('Retrieve Total Drink Quantity from menu where users choose the drink they like -- Using choiceItemDrink elements not choiceItemDrinkWithSelect elements', () => {
    document.body.innerHTML = 
      '<div class="choiceItemDrinkWithSelect" id="choiceItemDrinkWithSelect1">' +
      '<h3 class="drinkSelected" id="drinkSelected1"></h3>' +
      '<div class="choiceItemDrink" id="choiceItemDrink2">' +
      '<h3 class="drinkSelected" id="drinkSelected2">One Selected</h3>';

      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
      var totalDrinkQuantity = commonFunctions.retrieveTotalDrinkQuantity($);
      expect(totalDrinkQuantity).toEqual(1);
  });

  test('Retrieve Total Drink Quantity from menu where users choose the drink they like -- Using choiceItemDrinkWithSelect elements not choiceItemDrink elements', () => {
    document.body.innerHTML = 
      '<div class="choiceItemDrinkWithSelect" id="choiceItemDrinkWithSelect1">' +
      '<h3 class="drinkSelected" id="drinkSelected1"></h3>'+
      '<div class="choiceItemDrinkWithSelect" id="choiceItemDrinkWithSelect2">' +
      '<h3 class="drinkSelected" id="drinkSelected2">One Selected</h3>';

      const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
      var totalDrinkQuantity = commonFunctions.retrieveTotalDrinkQuantity($);
      expect(totalDrinkQuantity).toEqual(1);
  });
});

describe('enableAddToCartButtonForDrinkOnly Function', () => {
  test('Enable Add To Cart Button For Drink Only -- Button is enabled: selectDrink1 is undefined like water and bottle water AND quantity is not 0', () => {
    document.body.innerHTML =
      '<input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity1" disabled>' +
      '<button type="button" class="btn bg-light border addToCartForDrinkOnly" id="addToCartForDrinkOnly1" disabled>Add to Cart</button>';
    
    const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
    commonFunctions.enableAddToCartButtonForDrinkOnly(1, $);
    var buttonDisabled = $("#addToCartForDrinkOnly1").is(":disabled");
    expect(buttonDisabled).toBeFalsy();
  });

  test('Enable Add To Cart Button For Drink Only -- Button is disabled: selectDrink1 is undefined like water and bottle water AND quantity is 0', () => {
    document.body.innerHTML =
      '<input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity1" disabled>' +
      '<button type="button" class="btn bg-light border addToCartForDrinkOnly" id="addToCartForDrinkOnly1" disabled>Add to Cart</button>';
     
    const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
    commonFunctions.enableAddToCartButtonForDrinkOnly(1, $);
    var buttonDisabled = $("#addToCartForDrinkOnly1").is(":disabled");
    expect(buttonDisabled).toBeTruthy();  
  });

  test('Enable Add To Cart Button For Drink Only -- Button is enabled: selectDrink1 has been selected like canned, fountain and fresh juice AND quantity is 1', () => {
    document.body.innerHTML =
      '<select name="selectDrink" class="selectDrink" id="selectDrink1" style="height: 37px; padding: 0px 10px; ">' +
        '<option value ="1" disable>Coke</option>' +
      '</select>' +
      '<input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity1" disabled>' +
      '<button type="button" class="btn bg-light border addToCartForDrinkOnly" id="addToCartForDrinkOnly1" disabled>Add to Cart</button>';
     
    const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
    commonFunctions.enableAddToCartButtonForDrinkOnly(1, $);
    var buttonDisabled = $("#addToCartForDrinkOnly1").is(":disabled");
    expect(buttonDisabled).toBeFalsy();  
  });

  test('Enable Add To Cart Button For Drink Only -- Button is disabled: selectDrink1 is been selected like water and bottle water AND quantity is 0', () => {
    document.body.innerHTML =
      '<select name="selectDrink" class="selectDrink" id="selectDrink1" style="height: 37px; padding: 0px 10px; ">' +
        '<option value ="1" disable>Coke</option>' +
      '</select>' +
      '<input type="text" class="form-control w-25 d-inline text-center quantity" value="0" id="quantity1" disabled>' +
      '<button type="button" class="btn bg-light border addToCartForDrinkOnly" id="addToCartForDrinkOnly1" disabled>Add to Cart</button>';
     
    const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
    commonFunctions.enableAddToCartButtonForDrinkOnly(1, $);
    var buttonDisabled = $("#addToCartForDrinkOnly1").is(":disabled");
    expect(buttonDisabled).toBeTruthy();  
  });

  test('Enable Add To Cart Button For Drink Only -- Button is disabled: selectDrink1 is NOT been select like water and bottle water', () => {
    document.body.innerHTML =
      '<select name="selectDrink" class="selectDrink" id="selectDrink1" style="height: 37px; padding: 0px 10px; ">' +
        '<option value ="0" disable>Coke</option>' +
      '</select>' +
      '<input type="text" class="form-control w-25 d-inline text-center quantity" value="1" id="quantity1" disabled>' +
      '<button type="button" class="btn bg-light border addToCartForDrinkOnly" id="addToCartForDrinkOnly1" disabled>Add to Cart</button>';
     
    const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');
    commonFunctions.enableAddToCartButtonForDrinkOnly(1, $);
    var buttonDisabled = $("#addToCartForDrinkOnly1").is(":disabled");
    expect(buttonDisabled).toBeTruthy();  
  });
});

describe('loadEditModalForAppetizers Function', () => {
  test('Load Edit Modal For Appetizers', () => {
    var productItem = {"id":1, "name":"Egg Roll(5)", "price":4.59, "description":"5 egg rolls", "gallery":"EggRoll.jpg", "menu_id":1};
    var html = commonFunctions.loadEditModalForAppetizers(1, productItem, 1);
    expect(html).toMatch('4.59');
    expect(html).toMatchInlineSnapshot(`"<div class=\\"modal-body\\"><div class=\\"col-md-12 text-center\\"><div class=\\"choiceItem\\"><img src=\\"\\\\images\\\\EggRoll.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemName\\">Egg Roll(5)</span><br><span class=\\"choiceItemPrice\\">$4.59</span><br><div class=\\"quantityDiv mx-auto\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForUpdate\\" id=\\"quantityMinusForUpdate1\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center quantityForUpdate\\" value=\\"1\\" id=\\"quantityForUpdate1\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForUpdate\\" id=\\"quantityPlusForUpdate1\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div><div class=\\"modal-footer\\"><button type=\\"button\\" class=\\"btn btn-primary updateCart\\" id=\\"updateCart1AND1\\">Update</button><button type=\\"button\\" class=\\"btn btn-danger cancelModal\\" data-bs-dismiss=\\"modal\\">Cancel</button></div>"`);
  });
});

describe('loadEditModalForDrinksWithoutSelectBox Function', () => {
  test('Load Edit Modal For Drink Without Select Box like water and bottle water', () => {
    var productItem = {"id":5, "name":"Bottle Water", "price":1.50, "description":"Bottle water", "gallery":"", "menu_id":2, "category":"Bottle Water"};
    var drinkItem = {"id":2, "name":"Bottle Water", "description":"Bottle water", "gallery":"BottleWater.jpg", "tablename":""};
    var html = commonFunctions.loadEditModalForDrinksWithoutSelectBox(1, productItem, 1, drinkItem);
    expect(html).toMatch('Bottle Water');
    expect(html).toMatchInlineSnapshot(`"<div class=\\"modal-body\\"><div class=\\"col-md-12 text-center\\"><div class=\\"choiceItem\\"><input type=\\"hidden\\" id=\\"drinkId\\" value=2><img src=\\"\\\\images\\\\BottleWater.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemName\\">Bottle Water</span><br><span class=\\"choiceItemPrice\\">$1.50</span><br><div class=\\"quantityDiv mx-auto\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForUpdate\\" id=\\"quantityMinusForUpdate5\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center quantityForUpdate\\" value=\\"1\\" id=\\"quantityForUpdate5\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForUpdate\\" id=\\"quantityPlusForUpdate5\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div><div class=\\"modal-footer\\"><button type=\\"button\\" class=\\"btn btn-primary updateCart\\" id=\\"updateCart1AND5\\">Update</button><button type=\\"button\\" class=\\"btn btn-danger cancelModal\\" data-bs-dismiss=\\"modal\\">Cancel</button></div>"`);
  });
});

describe('loadEditModalForDrinksWithSelectDrinksOrSelectSizes Function', () => {
  test('Load Edit Modal For Drink With Select Drinks and NO Select Size like canned soft drink', () => {
    var productItem = {"id":6, "name":"Canned Soft Drink", "price":1.25, "description":"Soft drink canned", "gallery":"", "menu_id":2, "category":"Canned Drink"};
    var drinkItem = {"id":3, "name":"Canned Drink", "description":"A canned soft drink", "gallery":"SoftDrinkCan.jpg", "tablename":"cans"};
    var selectDrinkItem = {"id":1, "name":"Coke"};
    var selectDrinkItems = [];
    var selectDrinkItem1 = {"id":1, "name":"Coke"};
    var selectDrinkItem2 = {"id":2, "name":"Diet Coke"};
    var selectDrinkItem3 = {"id":3, "name":"Sprite"};
    var selectDrinkItem4 = {"id":4, "name":"Dr Pepper"};
    selectDrinkItems.push(selectDrinkItem1, selectDrinkItem2, selectDrinkItem3, selectDrinkItem4);
    var sizeProductItems = [];
    sizeProductItems.push(productItem);

    var html = commonFunctions.loadEditModalForDrinksWithSelectDrinksOrSelectSizes(1, productItem, 1, drinkItem, selectDrinkItems, selectDrinkItem, sizeProductItems);
    expect(html).toMatch('Canned Drink');
    expect(html).toMatchInlineSnapshot(`"<div class=\\"modal-body\\"><div class=\\"col-md-12 text-center\\"><div class=\\"choiceItem\\"><input type=\\"hidden\\" id=\\"drinkId\\" value=3><img src=\\"\\\\images\\\\SoftDrinkCan.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemDrinkName\\" id=\\"choiceItemDrinkName3\\">Canned Drink - $1.25</span><div style=\\"padding-top:10px; font-size:20px;\\"><select name=\\"selectDrink\\" class=\\"selectDrink\\" id=\\"selectDrink3\\" style=\\"height: 37px; padding: 0px 10px; \\"><option value=1 selected>Coke</option><option value=2 >Diet Coke</option><option value=3 >Sprite</option><option value=4 >Dr Pepper</option></select></div><div class=\\"quantityDiv mx-auto\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForUpdate\\" id=\\"quantityMinusForUpdate6\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center quantityForUpdate\\" value=\\"1\\" id=\\"quantityForUpdate6\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForUpdate\\" id=\\"quantityPlusForUpdate6\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div><div class=\\"modal-footer\\"><button type=\\"button\\" class=\\"btn btn-primary updateCart\\" id=\\"updateCart1AND6\\">Update</button><button type=\\"button\\" class=\\"btn btn-danger cancelModal\\" data-bs-dismiss=\\"modal\\">Cancel</button></div>"`);
  });

  test('Load Edit Modal For Drink With Select Drinks and NO Select Size like canned soft drink', () => {
    var productItem = {"id":7, "name":"Fountain Soft Drink Small", "price":1.59, "description":"Small size fountain soft drink", "gallery":"", "menu_id":2, "category":"Fountain Drink"};
    var drinkItem = {"id":4, "name":"Fountain Drink", "description":"Different size of fountain soft drink", "gallery":"SoftDrinkFountain.jpg", "tablename":"fountains"};
    var selectDrinkItem = {"id":1, "name":"Coke"};
    var selectDrinkItems = [];
    var selectDrinkItem1 = {"id":1, "name":"Coke"};
    var selectDrinkItem2 = {"id":2, "name":"Diet Coke"};
    var selectDrinkItem3 = {"id":3, "name":"Coke Zero"};
    var selectDrinkItem4 = {"id":4, "name":"Root Beer"};
    var selectDrinkItem5 = {"id":5, "name":"Fruitpia"};
    var selectDrinkItem6 = {"id":6, "name":"Nestea"};
    var selectDrinkItem7 = {"id":7, "name":"Sprite"};
    var selectDrinkItem8 = {"id":8, "name":"Fanta"};
    selectDrinkItems.push(selectDrinkItem1, selectDrinkItem2, selectDrinkItem3, selectDrinkItem4, selectDrinkItem5, selectDrinkItem6, selectDrinkItem7, selectDrinkItem8);
    var sizeProductItems = [];
    var productItem1 = {"id":7, "name":"Fountain Soft Drink Small", "price":1.59, "description":"Small size fountain soft drink", "gallery":"", "menu_id":2, "category":"Fountain Drink"};
    var productItem2 = {"id":8, "name":"Fountain Soft Drink Medium", "price":1.89, "description":"Medium size fountain soft drink", "gallery":"", "menu_id":2, "category":"Fountain Drink"};
    var productItem3 = {"id":9, "name":"Fountain Soft Drink Large", "price":2.19, "description":"Large size fountain soft drink", "gallery":"", "menu_id":2, "category":"Fountain Drink"};
    sizeProductItems.push(productItem1, productItem2, productItem3);

    var html = commonFunctions.loadEditModalForDrinksWithSelectDrinksOrSelectSizes(1, productItem, 1, drinkItem, selectDrinkItems, selectDrinkItem, sizeProductItems);
    expect(html).toMatch('Fountain Soft Drink Small');
    expect(html).toMatchInlineSnapshot(`"<div class=\\"modal-body\\"><div class=\\"col-md-12 text-center\\"><div class=\\"choiceItem\\"><input type=\\"hidden\\" id=\\"drinkId\\" value=4><img src=\\"\\\\images\\\\SoftDrinkFountain.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemDrinkName\\" id=\\"choiceItemDrinkName4\\">Fountain Drink</span><div style=\\"padding-top:10px; font-size:20px;\\"><select name=\\"selectDrink\\" class=\\"selectDrink\\" id=\\"selectDrink4\\" style=\\"height: 37px; padding: 0px 10px; \\"><option value=1 selected>Coke</option><option value=2 >Diet Coke</option><option value=3 >Coke Zero</option><option value=4 >Root Beer</option><option value=5 >Fruitpia</option><option value=6 >Nestea</option><option value=7 >Sprite</option><option value=8 >Fanta</option></select></div><div style=\\"padding-top:10px; font-size:20px;\\"><select name=\\"productDrinks\\" id=\\"productDrinks4\\" style=\\"height: 37px; padding: 0px 10px; \\"><option value=7 selected>Fountain Soft Drink Small - $1.59</option><option value=8 >Fountain Soft Drink Medium - $1.89</option><option value=9 >Fountain Soft Drink Large - $2.19</option></select></div><div class=\\"quantityDiv mx-auto\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForUpdate\\" id=\\"quantityMinusForUpdate7\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center quantityForUpdate\\" value=\\"1\\" id=\\"quantityForUpdate7\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForUpdate\\" id=\\"quantityPlusForUpdate7\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div><div class=\\"modal-footer\\"><button type=\\"button\\" class=\\"btn btn-primary updateCart\\" id=\\"updateCart1AND7\\">Update</button><button type=\\"button\\" class=\\"btn btn-danger cancelModal\\" data-bs-dismiss=\\"modal\\">Cancel</button></div>"`);
  });
});

describe('loadEditModalForSingleSideEntree Function', () => {
  test('Load Edit Modal For Single Side', () => {
    var productItem = {"id":17, "name":"Small Side", "price":2.49, "description":"Small size of side", "gallery":"", "menu_id":4, "category":"Side"};
    var sideItem = {"id":1, "name":"Fried Rice", "description":"Fried rice with some vegetable annd soy source", "gallery":"FriedRice.jpg"};
    var productSides = [];
    var productSide1 = {"id":17, "name":"Small Side", "price":2.49, "description":"Small size of side", "gallery":"", "menu_id":4, "category":"Side"};
    var productSide2 = {"id":18, "name":"Medium Side", "price":2.99, "description":"Medium size of side", "gallery":"", "menu_id":4, "category":"Side"};
    var productSide3 = {"id":19, "name":"Large Side", "price":3.49, "description":"Large size of side", "gallery":"", "menu_id":4, "category":"Side"};
    productSides.push(productSide1, productSide2, productSide3);

    var html = commonFunctions.loadEditModalForSingleSideEntree(1, productItem, 1, productSides, sideItem);
    expect(html).toMatch('Small Side');
    expect(html).toMatchInlineSnapshot(`"<div class=\\"modal-body\\"><div class=\\"col-md-12 text-center\\"><div class=\\"choiceItem\\"><input type=\\"hidden\\" id=\\"sideId\\" value=1><img src=\\"\\\\images\\\\FriedRice.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemSideOrEntreeName\\" id=\\"choiceItemSideOrEntreeName1\\">Fried Rice</span><div><select name=\\"productSidesOrEntrees\\" id=\\"productSidesOrEntrees1\\" style=\\"padding:5px 10px; font-size:18px;\\"><option value=17 selected>Small Side - $2.49</option><option value=18 >Medium Side - $2.99</option><option value=19 >Large Side - $3.49</option></select></div><div class=\\"quantityDiv mx-auto\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForUpdate\\" id=\\"quantityMinusForUpdate17\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center quantityForUpdate\\" value=\\"1\\" id=\\"quantityForUpdate17\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForUpdate\\" id=\\"quantityPlusForUpdate17\\"><i class=\\"fas fa-plus\\"></i></button></div></div><div class=\\"modal-footer\\"><button type=\\"button\\" class=\\"btn btn-primary updateCart\\" id=\\"updateCart1AND17\\">Update</button><button type=\\"button\\" class=\\"btn btn-danger cancelModal\\" data-bs-dismiss=\\"modal\\">Cancel</button></div>"`);
  });

  test('LOad Edit Modal For Single Entree', () => {
    var productItem = {"id":20, "name":"Small Chicken", "price":5.49, "description":"Small size of chicken entree", "gallery":"", "menu_id":4, "category":"Chicken"};
    var entreeItem = {"id":1, "name":"Fried Rice", "description":"Fried rice with some vegetable annd soy source", "gallery":"FriedRice.jpg"};
    var productEntrees = [];
    var productEntree1 = {"id":20, "name":"Small Chicken", "price":5.49, "description":"Small size of chicken entree", "gallery":"", "menu_id":4, "category":"Chicken"};
    var productEntree2 = {"id":21, "name":"Medium Chicken", "price":5.99, "description":"Small size of chicken entree", "gallery":"", "menu_id":4, "category":"Chicken"};
    var productEntree3 = {"id":22, "name":"Large Chicken", "price":6.49, "description":"Small size of chicken entree", "gallery":"", "menu_id":4, "category":"Chicken"};
    productEntrees.push(productEntree1, productEntree2, productEntree3);

    var html = commonFunctions.loadEditModalForSingleSideEntree(1, productItem, 1, productEntrees, entreeItem);
    expect(html).toMatch('Small Chicken');
    expect(html).toMatchInlineSnapshot(`"<div class=\\"modal-body\\"><div class=\\"col-md-12 text-center\\"><div class=\\"choiceItem\\"><input type=\\"hidden\\" id=\\"entreeId\\" value=1><img src=\\"\\\\images\\\\FriedRice.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemSideOrEntreeName\\" id=\\"choiceItemSideOrEntreeName1\\">Fried Rice</span><div><select name=\\"productSidesOrEntrees\\" id=\\"productSidesOrEntrees1\\" style=\\"padding:5px 10px; font-size:18px;\\"><option value=20 selected>Small Chicken - $5.49</option><option value=21 >Medium Chicken - $5.99</option><option value=22 >Large Chicken - $6.49</option></select></div><div class=\\"quantityDiv mx-auto\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForUpdate\\" id=\\"quantityMinusForUpdate20\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center quantityForUpdate\\" value=\\"1\\" id=\\"quantityForUpdate20\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForUpdate\\" id=\\"quantityPlusForUpdate20\\"><i class=\\"fas fa-plus\\"></i></button></div></div><div class=\\"modal-footer\\"><button type=\\"button\\" class=\\"btn btn-primary updateCart\\" id=\\"updateCart1AND20\\">Update</button><button type=\\"button\\" class=\\"btn btn-danger cancelModal\\" data-bs-dismiss=\\"modal\\">Cancel</button></div>"`);
  });
});

describe('loadEditModalForCombo Function', () => {
  test('Load Edit Modal For Combo with Kids Meal', () => {
    var productItem = {"id":16, "name":"Kid's Meal", "price":4.99, "description":"One small drink, one side and one entree", "gallery":"KidsMeal.jpg", "menu_id":3, "category":""};
    var sides = [];
    var side1 = {"id":1, "name":"Fried Rice", "description":"Fried rice with some vegetable annd soy source", "gallery":"FriedRice.jpg"};
    var side2 = {"id":2, "name":"Chow Mein", "description":"Chow mein with some vegetable", "gallery":"ChowMein.jpg"};
    var side3 = {"id":3, "name":"Steam White Rice", "description":"Plain steam white rice", "gallery":"SteamWhiteRice.jpg"};
    sides.push(side1, side2, side3);
    var chickenEntrees = [];
    var chicken1 = {"id":1, "name":"BBQ Chicken", "description":"BBQ chicken entree", "category":"Chicken", "gallery":"BBQChicken.jpg"};
    var chicken2 = {"id":2, "name":"Black Pepper Chicken", "description":"Black Pepper chicken entree", "category":"Chicken", "gallery":"BlackPepperChicken.jpg"};
    var chicken3 = {"id":3, "name":"General Taos Chicken", "description":"General Taos chicken entree", "category":"Chicken", "gallery":"GeneralTaosChicken.jpg"};
    var chicken4 = {"id":4, "name":"Jalapeno Chicken", "description":"Jalapeno chicken entree", "category":"Chicken", "gallery":"JalapenoChicken.jpg"};
    var chicken5 = {"id":5, "name":"Kung Pao Chicken", "description":"Kung pao chicken entree", "category":"Chicken", "gallery":"KungPaoChicken.jpg"};
    var chicken6 = {"id":6, "name":"Mushroom Chicken", "description":"Mushroom chicken entree", "category":"Chicken", "gallery":"MushroomChicken.jpg"};
    var chicken7 = {"id":7, "name":"Orange Chicken", "description":"Orange chicken entree", "category":"Chicken", "gallery":"OrangeChicken.jpg"};
    var chicken8 = {"id":8, "name":"String Bean Chicken", "description":"String bean chicken entree", "category":"Chicken", "gallery":"StringBeanChicken.jpg"};
    var chicken9 = {"id":9, "name":"Teriyaki Chicken", "description":"Teriyaki chicken entree", "category":"Chicken", "gallery":"TeriyakiChicken.jpg"};
    chickenEntrees.push(chicken1, chicken2, chicken3, chicken4, chicken5, chicken6, chicken7, chicken8, chicken9);
    var beefEntrees = [];
    var beef1 = {"id":1, "name":"Beef Broccoli", "description":"Beef broccoli entree", "category":"Beef", "gallery":"BeefBroccoli.jpg"};
    var beef2 = {"id":2, "name":"Hunan Beef", "description":"Hunan beef entree", "category":"Beef", "gallery":"HunanBeef.jpg"};
    var beef3 = {"id":3, "name":"Pepper Steak", "description":"Pepper Steak entree", "category":"Beef", "gallery":"PepperSteak.jpg"};
    beefEntrees.push(beef1, beef2, beef3);
    var shrimpEntrees = [];
    var shrimp1 = {"id":1, "name":"Broccoli Shrimp", "description":"Broccoli shrimp entree", "category":"Shrimp", "gallery":"BroccoliShrimp.jpg"};
    var shrimp2 = {"id":2, "name":"Kung Pao Shrimp", "description":"Kung pao shrimp entree", "category":"Shrimp", "gallery":"KungPaoShrimp.jpg"};
    shrimpEntrees.push(shrimp1, shrimp2);
    var combo = {"id":5, "product_id":16, "side":1, "entree":1, "drink":1};
    var comboDrinks = [];
    var drink1 = {"id":1, "name":"Small Drink", "description":"Small fountain drink for kid's meal", "price":0, "gallery":"SoftDrinkFountain.jpg", "tablename":"fountains"};
    var drink2 = {"id":2, "name":"Bottle Water", "description":"Bottle water for kid's meal", "price":0.75, "gallery":"BottleWater.jpg", "tablename":""};
    comboDrinks.push(drink1, drink2);
    var fountains = [];
    var fountain1 = {"id":1, "name":"Coke"};
    var fountain2 = {"id":2, "name":"Diet Coke"};
    var fountain3 = {"id":3, "name":"Coke Zero"};
    var fountain4 = {"id":4, "name":"Root Beer"};
    var fountain5 = {"id":5, "name":"Fruitpia"};
    var fountain6 = {"id":6, "name":"Nestea"};
    var fountain7 = {"id":7, "name":"Sprite"};
    var fountain8 = {"id":8, "name":"Fanta"};
    fountains.push(fountain1, fountain2, fountain3, fountain4, fountain5, fountain6, fountain7, fountain8);

    var html = commonFunctions.loadEditModalForCombo(1, productItem, 1, sides, chickenEntrees, beefEntrees, shrimpEntrees, combo, comboDrinks, fountains);
    expect(html).toMatch("Choose 1 Side (or Half/Half)");
    expect(html).toMatchInlineSnapshot(`"<div class=\\"modal-body\\"><div class=\\"row\\"><div class=\\"text-start\\"><h3>Choose 1 Side (or Half/Half)</h3><input type=\\"hidden\\" id=\\"sideMaxQuantity\\" value=\\"1\\"/><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemSide\\" id=\\"choiceItemSide1\\"><img src=\\"\\\\images\\\\FriedRice.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemSideName\\" id=\\"choiceItemSideName1\\">Fried Rice</span></div><div class=\\"selectedDiv\\"><h3 class=\\"sideSelected\\" id=\\"sideSelected1\\"></h3><div class=\\"sideQuantityIncrementDiv mx-auto\\" id=\\"sideQuantityIncrementDiv1\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityMinus\\" id=\\"sideQuantityMinus1\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center sideQuantity\\" value=\\"0\\" id=\\"sideQuantity1\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityPlus\\" id=\\"sideQuantityPlus1\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemSide\\" id=\\"choiceItemSide2\\"><img src=\\"\\\\images\\\\ChowMein.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemSideName\\" id=\\"choiceItemSideName2\\">Chow Mein</span></div><div class=\\"selectedDiv\\"><h3 class=\\"sideSelected\\" id=\\"sideSelected2\\"></h3><div class=\\"sideQuantityIncrementDiv mx-auto\\" id=\\"sideQuantityIncrementDiv2\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityMinus\\" id=\\"sideQuantityMinus2\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center sideQuantity\\" value=\\"0\\" id=\\"sideQuantity2\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityPlus\\" id=\\"sideQuantityPlus2\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemSide\\" id=\\"choiceItemSide3\\"><img src=\\"\\\\images\\\\SteamWhiteRice.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemSideName\\" id=\\"choiceItemSideName3\\">Steam White Rice</span></div><div class=\\"selectedDiv\\"><h3 class=\\"sideSelected\\" id=\\"sideSelected3\\"></h3><div class=\\"sideQuantityIncrementDiv mx-auto\\" id=\\"sideQuantityIncrementDiv3\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityMinus\\" id=\\"sideQuantityMinus3\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center sideQuantity\\" value=\\"0\\" id=\\"sideQuantity3\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityPlus\\" id=\\"sideQuantityPlus3\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div><div class=\\"text-start\\"><br><br><h3>Choose 1 Entree</h3><input type=\\"hidden\\" id=\\"entreeMaxQuantity\\" value=\\"1\\"/><h5>Chicken</h5></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree1\\"><img src=\\"\\\\images\\\\BBQChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName1\\">BBQ Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected1\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv1\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus1\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity1\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus1\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree2\\"><img src=\\"\\\\images\\\\BlackPepperChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName2\\">Black Pepper Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected2\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv2\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus2\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity2\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus2\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree3\\"><img src=\\"\\\\images\\\\GeneralTaosChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName3\\">General Taos Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected3\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv3\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus3\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity3\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus3\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree4\\"><img src=\\"\\\\images\\\\JalapenoChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName4\\">Jalapeno Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected4\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv4\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus4\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity4\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus4\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree5\\"><img src=\\"\\\\images\\\\KungPaoChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName5\\">Kung Pao Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected5\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv5\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus5\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity5\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus5\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree6\\"><img src=\\"\\\\images\\\\MushroomChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName6\\">Mushroom Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected6\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv6\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus6\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity6\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus6\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree7\\"><img src=\\"\\\\images\\\\OrangeChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName7\\">Orange Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected7\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv7\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus7\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity7\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus7\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree8\\"><img src=\\"\\\\images\\\\StringBeanChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName8\\">String Bean Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected8\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv8\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus8\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity8\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus8\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree9\\"><img src=\\"\\\\images\\\\TeriyakiChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName9\\">Teriyaki Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected9\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv9\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus9\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity9\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus9\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"text-start\\"><br><h5>Beef</h5></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree1\\"><img src=\\"\\\\images\\\\BeefBroccoli.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName1\\">Beef Broccoli</span></div><div class=\\"selectedDi\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected1\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv1\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus1\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity1\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus1\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree2\\"><img src=\\"\\\\images\\\\HunanBeef.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName2\\">Hunan Beef</span></div><div class=\\"selectedDi\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected2\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv2\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus2\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity2\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus2\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree3\\"><img src=\\"\\\\images\\\\PepperSteak.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName3\\">Pepper Steak</span></div><div class=\\"selectedDi\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected3\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv3\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus3\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity3\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus3\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"text-start\\"><br><h5>Shrimp</h5></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree1\\"><img src=\\"\\\\images\\\\BroccoliShrimp.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName1\\">Broccoli Shrimp</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected1\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv1\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus1\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity1\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus1\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree2\\"><img src=\\"\\\\images\\\\KungPaoShrimp.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName2\\">Kung Pao Shrimp</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected2\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv2\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus2\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity2\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus2\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"text-start\\"><br><h3>Choose 1 Drink (Default: Small Fountain Drink)</h3><input type=\\"hidden\\" id=\\"drinkMaxQuantity\\" value=\\"1\\"/><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemDrinkWithSelect\\" id=\\"choiceItemDrinkWithSelect1\\"><img src=\\"\\\\images\\\\SoftDrinkFountain.jpg\\" style=\\"width:60%\\"><div style=\\"padding-top:10px; font-size:20px;\\"><span class=\\"choiceItemDrinkName\\" id=\\"choiceItemDrinkName1\\">Small Drink</span><select name=\\"comboDrink\\" class=\\"comboDrink\\" id=\\"comboDrink1\\" style=\\"height: 37px; padding: 4px 10px; margin: 0px 10px\\"><option value = \\"0\\" selected disable>Choose the flavor</option><option value=1>Coke</option><option value=2>Diet Coke</option><option value=3>Coke Zero</option><option value=4>Root Beer</option><option value=5>Fruitpia</option><option value=6>Nestea</option><option value=7>Sprite</option><option value=8>Fanta</option></select></div></div><div class=\\"selectedDiv\\"><h3 class=\\"drinkSelected\\" id=\\"drinkSelected1\\"></h3></div></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemDrink\\" id=\\"choiceItemDrink2\\"><img src=\\"\\\\images\\\\BottleWater.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemDrinkName\\" id=\\"choiceItemDrinkName2\\">Bottle Water - Extra Charge: $0.75</span></div><div class=\\"selectedDiv\\"><h3 class=\\"drinkSelected\\" id=\\"drinkSelected2\\"></h3></div></div><div class=\\"col-md-4 my-auto\\"><div class=\\"quantityDiv mx-auto\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForUpdate\\" id=\\"quantityMinusForUpdate16\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center quantityForUpdate\\" value=\\"1\\" id=\\"quantityForUpdate16\\" disabled style=\\"margin: 0px 10px\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForUpdate\\" id=\\"quantityPlusForUpdate16\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div><br><div class=\\"modal-footer\\"><button type=\\"button\\" class=\\"btn btn-primary updateCart\\" id=\\"updateCart1AND16\\">Update</button><button type=\\"button\\" class=\\"btn btn-danger cancelModal\\" data-bs-dismiss=\\"modal\\">Cancel</button></div>"`);
  });

  test('Load Edit Modal For Combo with Party Tray', () => {
    var productItem = {"id":15, "name":"Party Tray", "price":23.99, "description":"3 sides & 3 large entrees", "gallery":"PartyTray.jpg", "menu_id":3, "category":""};
    var sides = [];
    var side1 = {"id":1, "name":"Fried Rice", "description":"Fried rice with some vegetable annd soy source", "gallery":"FriedRice.jpg"};
    var side2 = {"id":2, "name":"Chow Mein", "description":"Chow mein with some vegetable", "gallery":"ChowMein.jpg"};
    var side3 = {"id":3, "name":"Steam White Rice", "description":"Plain steam white rice", "gallery":"SteamWhiteRice.jpg"};
    sides.push(side1, side2, side3);
    var chickenEntrees = [];
    var chicken1 = {"id":1, "name":"BBQ Chicken", "description":"BBQ chicken entree", "category":"Chicken", "gallery":"BBQChicken.jpg"};
    var chicken2 = {"id":2, "name":"Black Pepper Chicken", "description":"Black Pepper chicken entree", "category":"Chicken", "gallery":"BlackPepperChicken.jpg"};
    var chicken3 = {"id":3, "name":"General Taos Chicken", "description":"General Taos chicken entree", "category":"Chicken", "gallery":"GeneralTaosChicken.jpg"};
    var chicken4 = {"id":4, "name":"Jalapeno Chicken", "description":"Jalapeno chicken entree", "category":"Chicken", "gallery":"JalapenoChicken.jpg"};
    var chicken5 = {"id":5, "name":"Kung Pao Chicken", "description":"Kung pao chicken entree", "category":"Chicken", "gallery":"KungPaoChicken.jpg"};
    var chicken6 = {"id":6, "name":"Mushroom Chicken", "description":"Mushroom chicken entree", "category":"Chicken", "gallery":"MushroomChicken.jpg"};
    var chicken7 = {"id":7, "name":"Orange Chicken", "description":"Orange chicken entree", "category":"Chicken", "gallery":"OrangeChicken.jpg"};
    var chicken8 = {"id":8, "name":"String Bean Chicken", "description":"String bean chicken entree", "category":"Chicken", "gallery":"StringBeanChicken.jpg"};
    var chicken9 = {"id":9, "name":"Teriyaki Chicken", "description":"Teriyaki chicken entree", "category":"Chicken", "gallery":"TeriyakiChicken.jpg"};
    chickenEntrees.push(chicken1, chicken2, chicken3, chicken4, chicken5, chicken6, chicken7, chicken8, chicken9);
    var beefEntrees = [];
    var beef1 = {"id":1, "name":"Beef Broccoli", "description":"Beef broccoli entree", "category":"Beef", "gallery":"BeefBroccoli.jpg"};
    var beef2 = {"id":2, "name":"Hunan Beef", "description":"Hunan beef entree", "category":"Beef", "gallery":"HunanBeef.jpg"};
    var beef3 = {"id":3, "name":"Pepper Steak", "description":"Pepper Steak entree", "category":"Beef", "gallery":"PepperSteak.jpg"};
    beefEntrees.push(beef1, beef2, beef3);
    var shrimpEntrees = [];
    var shrimp1 = {"id":1, "name":"Broccoli Shrimp", "description":"Broccoli shrimp entree", "category":"Shrimp", "gallery":"BroccoliShrimp.jpg"};
    var shrimp2 = {"id":2, "name":"Kung Pao Shrimp", "description":"Kung pao shrimp entree", "category":"Shrimp", "gallery":"KungPaoShrimp.jpg"};
    shrimpEntrees.push(shrimp1, shrimp2);
    var combo = {"id":4, "product_id":15, "side":3, "entree":3, "drink":0};
    var comboDrinks = [];
    var drink1 = {"id":1, "name":"Small Drink", "description":"Small fountain drink for kid's meal", "price":0, "gallery":"SoftDrinkFountain.jpg", "tablename":"fountains"};
    var drink2 = {"id":2, "name":"Bottle Water", "description":"Bottle water for kid's meal", "price":0.75, "gallery":"BottleWater.jpg", "tablename":""};
    comboDrinks.push(drink1, drink2);
    var fountains = [];
    var fountain1 = {"id":1, "name":"Coke"};
    var fountain2 = {"id":2, "name":"Diet Coke"};
    var fountain3 = {"id":3, "name":"Coke Zero"};
    var fountain4 = {"id":4, "name":"Root Beer"};
    var fountain5 = {"id":5, "name":"Fruitpia"};
    var fountain6 = {"id":6, "name":"Nestea"};
    var fountain7 = {"id":7, "name":"Sprite"};
    var fountain8 = {"id":8, "name":"Fanta"};
    fountains.push(fountain1, fountain2, fountain3, fountain4, fountain5, fountain6, fountain7, fountain8);

    var html = commonFunctions.loadEditModalForCombo(1, productItem, 1, sides, chickenEntrees, beefEntrees, shrimpEntrees, combo, comboDrinks, fountains);
    expect(html).toMatch("Choose 3 Sides");
    expect(html).toMatchInlineSnapshot(`"<div class=\\"modal-body\\"><div class=\\"row\\"><div class=\\"text-start\\"><h3>Choose 3 Sides</h3><input type=\\"hidden\\" id=\\"sideMaxQuantity\\" value=\\"3\\"/><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemSide\\" id=\\"choiceItemSide1\\"><img src=\\"\\\\images\\\\FriedRice.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemSideName\\" id=\\"choiceItemSideName1\\">Fried Rice</span></div><div class=\\"selectedDiv\\"><h3 class=\\"sideSelected\\" id=\\"sideSelected1\\"></h3><div class=\\"sideQuantityIncrementDiv mx-auto\\" id=\\"sideQuantityIncrementDiv1\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityMinus\\" id=\\"sideQuantityMinus1\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center sideQuantity\\" value=\\"0\\" id=\\"sideQuantity1\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityPlus\\" id=\\"sideQuantityPlus1\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemSide\\" id=\\"choiceItemSide2\\"><img src=\\"\\\\images\\\\ChowMein.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemSideName\\" id=\\"choiceItemSideName2\\">Chow Mein</span></div><div class=\\"selectedDiv\\"><h3 class=\\"sideSelected\\" id=\\"sideSelected2\\"></h3><div class=\\"sideQuantityIncrementDiv mx-auto\\" id=\\"sideQuantityIncrementDiv2\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityMinus\\" id=\\"sideQuantityMinus2\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center sideQuantity\\" value=\\"0\\" id=\\"sideQuantity2\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityPlus\\" id=\\"sideQuantityPlus2\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemSide\\" id=\\"choiceItemSide3\\"><img src=\\"\\\\images\\\\SteamWhiteRice.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemSideName\\" id=\\"choiceItemSideName3\\">Steam White Rice</span></div><div class=\\"selectedDiv\\"><h3 class=\\"sideSelected\\" id=\\"sideSelected3\\"></h3><div class=\\"sideQuantityIncrementDiv mx-auto\\" id=\\"sideQuantityIncrementDiv3\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityMinus\\" id=\\"sideQuantityMinus3\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center sideQuantity\\" value=\\"0\\" id=\\"sideQuantity3\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle sideQuantityPlus\\" id=\\"sideQuantityPlus3\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div><div class=\\"text-start\\"><br><br><h3>Choose 3 Entrees</h3><input type=\\"hidden\\" id=\\"entreeMaxQuantity\\" value=\\"3\\"/><h5>Chicken</h5></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree1\\"><img src=\\"\\\\images\\\\BBQChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName1\\">BBQ Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected1\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv1\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus1\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity1\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus1\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree2\\"><img src=\\"\\\\images\\\\BlackPepperChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName2\\">Black Pepper Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected2\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv2\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus2\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity2\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus2\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree3\\"><img src=\\"\\\\images\\\\GeneralTaosChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName3\\">General Taos Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected3\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv3\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus3\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity3\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus3\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree4\\"><img src=\\"\\\\images\\\\JalapenoChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName4\\">Jalapeno Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected4\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv4\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus4\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity4\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus4\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree5\\"><img src=\\"\\\\images\\\\KungPaoChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName5\\">Kung Pao Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected5\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv5\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus5\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity5\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus5\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree6\\"><img src=\\"\\\\images\\\\MushroomChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName6\\">Mushroom Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected6\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv6\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus6\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity6\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus6\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree7\\"><img src=\\"\\\\images\\\\OrangeChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName7\\">Orange Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected7\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv7\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus7\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity7\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus7\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree8\\"><img src=\\"\\\\images\\\\StringBeanChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName8\\">String Bean Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected8\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv8\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus8\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity8\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus8\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree9\\"><img src=\\"\\\\images\\\\TeriyakiChicken.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName9\\">Teriyaki Chicken</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected9\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv9\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus9\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity9\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus9\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"text-start\\"><br><h5>Beef</h5></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree1\\"><img src=\\"\\\\images\\\\BeefBroccoli.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName1\\">Beef Broccoli</span></div><div class=\\"selectedDi\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected1\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv1\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus1\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity1\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus1\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree2\\"><img src=\\"\\\\images\\\\HunanBeef.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName2\\">Hunan Beef</span></div><div class=\\"selectedDi\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected2\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv2\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus2\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity2\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus2\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree3\\"><img src=\\"\\\\images\\\\PepperSteak.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName3\\">Pepper Steak</span></div><div class=\\"selectedDi\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected3\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv3\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus3\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity3\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus3\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"text-start\\"><br><h5>Shrimp</h5></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree1\\"><img src=\\"\\\\images\\\\BroccoliShrimp.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName1\\">Broccoli Shrimp</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected1\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv1\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus1\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity1\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus1\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 text-center\\"><div class=\\"choiceItemEntree\\" id=\\"choiceItemEntree2\\"><img src=\\"\\\\images\\\\KungPaoShrimp.jpg\\" style=\\"width:60%\\"><br><span class=\\"choiceItemEntreeName\\" id=\\"choiceItemEntreeName2\\">Kung Pao Shrimp</span></div><div class=\\"selectedDiv\\"><h3 class=\\"entreeSelected\\" id=\\"entreeSelected2\\"></h3><div class=\\"entreeQuantityIncrementDiv mx-auto\\" id=\\"entreeQuantityIncrementDiv2\\" style=\\"display: none;\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityMinus\\" id=\\"entreeQuantityMinus2\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center entreeQuantity\\" value=\\"0\\" id=\\"entreeQuantity2\\" disabled><button type=\\"button\\" class=\\"btn bg-light border rounded-circle entreeQuantityPlus\\" id=\\"entreeQuantityPlus2\\"><i class=\\"fas fa-plus\\"></i></button></div></div><br></div><div class=\\"col-md-4 my-auto\\"><div class=\\"quantityDiv mx-auto\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityMinusForUpdate\\" id=\\"quantityMinusForUpdate15\\"><i class=\\"fas fa-minus\\"></i></button><input type=\\"text\\" class=\\"form-control w-25 d-inline text-center quantityForUpdate\\" value=\\"1\\" id=\\"quantityForUpdate15\\" disabled style=\\"margin: 0px 10px\\"><button type=\\"button\\" class=\\"btn bg-light border rounded-circle quantityPlusForUpdate\\" id=\\"quantityPlusForUpdate15\\"><i class=\\"fas fa-plus\\"></i></button></div></div></div></div><br><div class=\\"modal-footer\\"><button type=\\"button\\" class=\\"btn btn-primary updateCart\\" id=\\"updateCart1AND15\\">Update</button><button type=\\"button\\" class=\\"btn btn-danger cancelModal\\" data-bs-dismiss=\\"modal\\">Cancel</button></div>"`);
  });  
});

describe('loadMessage Function', () => {
    test("Load Message", () => {
      var html = commonFunctions.loadMessage("Great Jobs");
      expect(html).toMatch("Great Job");
      expect(html).toMatchInlineSnapshot(`"<div class=\\"modal-body\\"><div class=\\"col-md-12 text-center\\"><h5>Great Jobs</h5></div></div><div class=\\"modal-footer\\"><button type=\\"button\\" class=\\"btn btn-primary okModal\\" data-bs-dismiss=\\"modal\\">OK</button></div>"`);
    });
});

describe('retrieveSubItemsForCombo Function', () => {
  const $ = require('../../../../node_modules/jquery/dist/jquery.min.js');

  describe('Retrieve SubItems for Combo --For Side', () => {
    test("Half/Half Selected", () => {
      document.body.innerHTML =
      '<div class="choiceItemSide" id="choiceItemSide1">' +
      '<h3 class="sideSelected" id="sideSelected1">Half Selected</h3>' + 
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="0" id="sideQuantity1" disabled>' +
      '<div class="choiceItemSide" id="choiceItemSide2">' +
      '<h3 class="sideSelected" id="sideSelected2">Half Selected</h3>' +
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="0" id="sideQuantity2" disabled>';
  
      var json = commonFunctions.retrieveSubItemsForCombo($);
      expect(json).toBe("[{\"category\":\"Side\",\"id\":\"1\",\"quantity\":0.5},{\"category\":\"Side\",\"id\":\"2\",\"quantity\":0.5}]");
    });
  
    test("One Selected", () => {
      document.body.innerHTML =
      '<div class="choiceItemSide" id="choiceItemSide1">' +
      '<h3 class="sideSelected" id="sideSelected1">One Selected</h3>' + 
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="0" id="sideQuantity1" disabled>' +
      '<div class="choiceItemSide" id="choiceItemSide2">' +
      '<h3 class="sideSelected" id="sideSelected2"></h3>' +
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="0" id="sideQuantity2" disabled>';
  
      var json = commonFunctions.retrieveSubItemsForCombo($);
      expect(json).toBe("[{\"category\":\"Side\",\"id\":\"1\",\"quantity\":1}]");
    });
  
    test("Quantity != 0", () => {
      document.body.innerHTML =
      '<div class="choiceItemSide" id="choiceItemSide1">' +
      '<h3 class="sideSelected" id="sideSelected1"></h3>' + 
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="1" id="sideQuantity1" disabled>' +
      '<div class="choiceItemSide" id="choiceItemSide2">' +
      '<h3 class="sideSelected" id="sideSelected2"></h3>' +
      '<input type="text" class="form-control w-25 d-inline text-center sideQuantity" value="2" id="sideQuantity2" disabled>';
  
      var json = commonFunctions.retrieveSubItemsForCombo($);
      expect(json).toBe("[{\"category\":\"Side\",\"id\":\"1\",\"quantity\":1},{\"category\":\"Side\",\"id\":\"2\",\"quantity\":2}]");
    });
  });
  
  describe('Retrieve SubItems for Combo --For Entree', () => {
    test("One Selected", () => {
      document.body.innerHTML =
      '<div class="choiceItemEntree" id="choiceItemEntree1">' +
      '<h3 class="entreeSelected" id="entreeSelected1">One Selected</h3>' + 
      '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity1" disabled>' +
      '<div class="choiceItemEntree" id="choiceItemEntree2">' +
      '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
      '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="0" id="entreeQuantity2" disabled>';

      var json = commonFunctions.retrieveSubItemsForCombo($);
      expect(json).toBe("[{\"category\":\"Entree\",\"id\":\"1\",\"quantity\":1}]");
    });

    test("quantity != 0", () => {
      document.body.innerHTML =
      '<div class="choiceItemEntree" id="choiceItemEntree1">' +
      '<h3 class="entreeSelected" id="entreeSelected1"></h3>' + 
      '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="1" id="entreeQuantity1" disabled>' +
      '<div class="choiceItemEntree" id="choiceItemEntree2">' +
      '<h3 class="entreeSelected" id="entreeSelected2"></h3>' +
      '<input type="text" class="form-control w-25 d-inline text-center entreeQuantity" value="2" id="entreeQuantity2" disabled>';

      var json = commonFunctions.retrieveSubItemsForCombo($);
      expect(json).toBe("[{\"category\":\"Entree\",\"id\":\"1\",\"quantity\":1},{\"category\":\"Entree\",\"id\":\"2\",\"quantity\":2}]");
    });
  });  

  describe('Retrieve SubItems for Combo --For Drink', () => {
    test("Without Select -- Bottle Water", () => {
      document.body.innerHTML =
        '<input type="hidden" id="drinkMaxQuantity" value="1"/>' +
        '<div class="choiceItemDrinkWithSelect" id="choiceItemDrinkWithSelect1">' +
        '<h3 class="drinkSelected" id="drinkSelected1"></h3>' +
        '<div class="choiceItemDrink" id="choiceItemDrink2">' +
        '<h3 class="drinkSelected" id="drinkSelected2">One Selected</h3>';

      var json = commonFunctions.retrieveSubItemsForCombo($);
      expect(json).toBe("[{\"category\":\"Drink\",\"id\":\"2\",\"quantity\":1}]");
    });

    test("With Select -- Fountain Drink", () => {
      document.body.innerHTML =
        '<input type="hidden" id="drinkMaxQuantity" value="1"/>' +
        '<div class="choiceItemDrinkWithSelect" id="choiceItemDrinkWithSelect1">' +
        '<h3 class="drinkSelected" id="drinkSelected1">One Selected</h3>' +
        '<select name="comboDrink" class="comboDrink" id="comboDrink1" style="height: 37px; padding: 4px 10px; margin: 0px 10px">' +
            '<option value = "1" selected disable>Coke</option>' +
        '</select>' +
        '<div class="choiceItemDrink" id="choiceItemDrink2">' +
        '<h3 class="drinkSelected" id="drinkSelected2"></h3>';

      var json = commonFunctions.retrieveSubItemsForCombo($);
      expect(json).toBe("[{\"category\":\"Drink\",\"id\":\"1\",\"quantity\":1,\"selectBoxId\":\"1\"}]");
    });
  });  
});