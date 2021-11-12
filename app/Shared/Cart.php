<?php

namespace App\Shared;

use Illuminate\Support\Facades\DB;


Class Cart {
    public $serialNumber = 0;
    public $items = array();
    public $totalQuantity = 0;
    public $totalPrice = 0;

    function __construct($oldCart) {
        if ($oldCart) {
            $this->serialNumber = $oldCart->serialNumber;
            $this->items = $oldCart->items;
            $this->totalQuantity = $oldCart->totalQuantity;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function addNewItem($item, $quantity, $subItems) {
        $subItems = $this->processSubItems($subItems);
        $totalPricePerItem = $this->retrieveTotalPricePerItemWithExtraCharge($item, $subItems);
        if (!$this->canNewItemBeMerged($item, $quantity, $subItems)) {
            $newItemSerialNumber = $this->serialNumber+1;
            $storedItem = ['item'=>$item, 'subItems'=>$subItems, 'quantity'=>$quantity, 'totalPricePerItem'=>$totalPricePerItem];
            $this->items[$newItemSerialNumber] = $storedItem;
            $this->totalQuantity += $quantity;
            $this->totalPrice += ((double)($totalPricePerItem) * $quantity);    // $totalPricePerItem = $item->price + Extra Charge from subItems
            $this->serialNumber = $newItemSerialNumber;
        }
        
    }

    public function updateItemQuantity($serialNumber, $quantity) {
        $originalStoredItem = $this->items[$serialNumber];
        $originalItem = $originalStoredItem['item'];
        $originalSubItems = $originalStoredItem['subItems'];
        $originalQuantity = $originalStoredItem['quantity'];
        $originalTotalPricePerItem = $originalStoredItem['totalPricePerItem'];
        $quantityChanged = $quantity - $originalQuantity;
        $priceChanged = (double)($originalTotalPricePerItem * $quantityChanged);
        $newStoredItem = ['item'=>$originalItem, 'subItems'=>$originalSubItems, 'quantity'=>$quantity, 'totalPricePerItem'=>$originalTotalPricePerItem];
        $this->items[$serialNumber] = $newStoredItem;
        $this->totalQuantity += $quantityChanged;
        $this->totalPrice += $priceChanged;
        if ($quantity == 0) {
            unset($this->items[$serialNumber]);
        }
    }

    public function updateItem($serialNumber, $productId, $quantity, $subItems) {
        $originalProductId = $this->items[$serialNumber]['item']->id;
        if ($originalProductId != $productId) { // Check if productId changed for Drinks: Fountain and Juice (size changed) and Individual Side/Entrees (size changed)
            $this->updateItemQuantity($serialNumber, 0);    
            $newProduct = DB::table('products')->where('id', $productId)->first();
            $this->addNewItem($newProduct, $quantity, $subItems);
        } else if ($this->checkIfExtraChargeChanged($this->items[$serialNumber]['subItems'], $subItems) == true) { // Combo with drink which selected with different extra charge
            $this->updateItemQuantity($serialNumber, 0);
            $product = DB::table('products')->where('id', $productId)->first();
            $this->addNewItem($product, $quantity, $subItems);
        } else {
            $this->updateItemQuantity($serialNumber, $quantity);
            if ($quantity != 0) {
                $subItems = $this->processSubItems($subItems);
                $originalStoredItem = $this->items[$serialNumber];
                $originalItem = $originalStoredItem['item'];
                $originalSubItems = $originalStoredItem['subItems'];
                $originalQuantity = $originalStoredItem['quantity'];
                $originalTotalPricePerItem = $originalStoredItem['totalPricePerItem'];
                $newStoredItem = ['item'=>$originalItem, 'subItems'=>$subItems, 'quantity'=>$originalQuantity, 'totalPricePerItem'=>$originalTotalPricePerItem];
                $this->items[$serialNumber] = $newStoredItem;
            }
        }
    }

    protected function canNewItemBeMerged($item, $quantity, $subItems) {
        $keys = Array_keys($this->items);
        foreach ($keys as $key) {
            if ($this->items[$key]['item']->id == $item->id) {
                if ($this->areSubItemsSame($this->items[$key]['subItems'], $subItems)) {    
                    $this->items[$key]['quantity'] += $quantity;
                    $this->totalQuantity += $quantity;
                    $this->totalPrice += $this->items[$key]['item']->price * $quantity;
                    return true; 
                }
            }
        }
        return false;
    }

    protected function areSubItemsSame($originalSubItems, $newSubItems) {    // ToDo Needs to verify how to check the subItem is the same
        if ($originalSubItems == $newSubItems) {
            return true;
        }
        return false;
    }

    protected function processSubItems($subItems) {
        $newSubItems = array();
        $item = null;
        $selectDrink = null;

        if (($subItems == null) || count($subItems) == 0) {
            return $newSubItems;
        }

        $keys = Array_keys($subItems);

        foreach ($keys as $key) {
            $category = $subItems[$key]['category'];
            $quantity = $subItems[$key]['quantity'];
            $id = $subItems[$key]['id'];

            // This is for Combo or Individual Side/Entree
            if ($category == 'Side') {
                $item = DB::table('sides')->where('id', $id)->first();
            } else if ($category == "Entree") {
                $item = DB::table('entrees')->where('id', $id)->first();
            } else if ($category == 'Drink') {
                $item = DB::table('combodrinks')->where('id', $id)->first();
            } else if ($category == 'DrinkOnly') {  // This is for Drink -- Water, Fresh Juice, Fountain, Canned, Bottle Water
                $item = DB::table('drinks')->where('id', $id)->first();
            }
            if (array_key_exists('selectBoxId', $subItems[$key])) {    // selectBoxId is set at Kid's meal drink -- retrieveSubItems -- for combo OR set at addToCartForDrinkOnly click event -- for DrinkOnly
                $selectBoxId = $subItems[$key]['selectBoxId'];
                if ($selectBoxId != null) {
                    $selectDrink = DB::table($item->tablename)->where('id', $selectBoxId)->first();
                    array_push($newSubItems, ['category'=>$category, 'item'=>$item, 'quantity'=>$quantity, 'selectDrink'=>$selectDrink]);
                } else {
                    array_push($newSubItems, ['category'=>$category, 'item'=>$item, 'quantity'=>$quantity]);    // This is for DrinkOnly -- retrieve image from $item for Water and Bottle Water
                }
            } else {
                array_push($newSubItems, ['category'=>$category, 'item'=>$item, 'quantity'=>$quantity]);
            }
        }
        return $newSubItems;
    }

    protected function retrieveTotalPricePerItemWithExtraCharge($item, $subItems) {
        $totalPricePerItem = $item->price;  // This $item is from product table

        if (($subItems == null) || count($subItems) == 0) {
            return $totalPricePerItem;
        }

        $keys = Array_keys($subItems);
        foreach ($keys as $key) {
            $category = $subItems[$key]['category'];
            $quantity = $subItems[$key]['quantity'];
            $item = $subItems[$key]['item'];  // After run processSubItems, we need to use item insead of id in subItems, this is from combodrinks table
            if ($category == 'Drink') {
                $totalPricePerItem += (double)$item->price; // The price is from combodrinks table
            }
        }

        return $totalPricePerItem;
    }

    protected function checkIfExtraChargeChanged($originalSubItems, $newSubItems) { // This check if Combo is with extra charge changed -- select different drink which affect extra charge
        if (($originalSubItems == null) || count($originalSubItems) == 0) { // Update Item for combo with drink -- which always has subItems
            return false;
        }
        $originalExtraCharge = 0;
        $newExtraCharge = 0;

        $keys = Array_keys($originalSubItems);
        foreach ($keys as $key) {
            $category = $originalSubItems[$key]['category'];
            $quantity = $originalSubItems[$key]['quantity'];
            $item = $originalSubItems[$key]['item'];  // After run processSubItems, we need to use item insead of id in subItems, this is from combodrinks table
            if ($category == 'Drink') {
                $originalExtraCharge = (double)$item->price; // The price is from combodrinks table
            }
        }

        $keys = Array_keys($newSubItems);
        foreach ($keys as $key) {
            $category = $newSubItems[$key]['category'];
            $quantity = $newSubItems[$key]['quantity'];
            $id = $newSubItems[$key]['id'];  // New subItem is before run processSubItems, so it just has id not item yet. Need to get from combodrinks table
            if ($category == 'Drink') {
                $item = DB::table('combodrinks')->where('id', $id)->first();
                $newExtraCharge = (double)$item->price; // The price is from combodrinks table
            }
        }

        return ($originalExtraCharge != $newExtraCharge)? true: false;
    }
}