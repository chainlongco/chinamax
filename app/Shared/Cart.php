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
        $keys = Array_keys($subItems);

        foreach ($keys as $key) {
            $category = $subItems[$key]['category'];
            $quantity = $subItems[$key]['quantity'];
            $id = $subItems[$key]['id'];
            if ($category == 'Side') {
                $item = DB::table('sides')->where('id', $id)->first();
            } else if ($category == "Entree") {
                $item = DB::table('entrees')->where('id', $id)->first();
            } else if ($category == 'Drink') {
                $item = DB::table('combodrinks')->where('id', $id)->first();
            }
            if (array_key_exists('selectId', $subItems[$key])) {
                $selectId = $subItems[$key]['selectId'];
                $selectDrink = DB::table($item->tablename)->where('id', $selectId)->first();
                array_push($newSubItems, ['category'=>$category, 'item'=>$item, 'quantity'=>$quantity, 'selectDrink'=>$selectDrink]);
            } else {
                array_push($newSubItems, ['category'=>$category, 'item'=>$item, 'quantity'=>$quantity]);
            }
            
        }
        return $newSubItems;
    }

    protected function retrieveTotalPricePerItemWithExtraCharge($item, $subItems) {
        $totalPricePerItem = $item->price;  // This $item is from product table

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
}