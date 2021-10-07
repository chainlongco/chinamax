<?php

namespace App\Shared;

Class Cart {
    public $serialNumber = 0;
    public $items = null;
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

    public function addNewItem($item, $quantity, $subItem) {
        if (!$this->canNewItemBeMerged($item, $quantity, $subItem)) {
            $newItemSerialNumber = $this->serialNumber+1;
            $storedItem = ['item'=>$item, 'subItem'=>$subItem, 'quantity'=>$quantity];
            $this->items[$newItemSerialNumber] = $storedItem;
            $this->totalQuantity += $quantity;
            $this->totalPrice += ((double)($item->price) * $quantity);
            $this->serialNumber = $newItemSerialNumber;
        }
    }

    public function updateItemQuantity($serialNumber, $quantity) {
        $originalStoredItem = $this->items[$serialNumber];
        $originalItem = $originalStoredItem['item'];
        $originalSubItem = $originalStoredItem['subItem'];
        $originalQuantity = $originalStoredItem['quantity'];
        $quantityChanged = $quantity - $originalQuantity;
        $priceChanged = $originalItem->price * $quantityChanged;
        $newStoredItem = ['item'=>$originalItem, 'subItem'=>$originalSubItem, 'quantity'=>$quantity];
        $this->items[$serialNumber] = $newStoredItem;
        $this->totalQuantity += $quantityChanged;
        $this->totalPrice += $priceChanged;
        if ($quantity == 0) {
            unset($this->items[$serialNumber]);
        }
    }

    protected function canNewItemBeMerged($item, $quantity, $subItem) {
        $keys = Array_keys($this->items);
        foreach ($keys as $key) {
            if ($this->items[$key]['item']->id == $item->id) {
                if ($this->areSubItemsSame($this->items[$key]['subItem'], $subItem)) {    
                    $this->items[$key]['quantity'] += $quantity;
                    $this->totalQuantity += $quantity;
                    $this->totalPrice += $this->items[$key]['item']->price * $quantity;
                    return true; 
                }
            }
        }
        return false;
    }

    protected function areSubItemsSame($originalSubItem, $newSubItem) {    // ToDo Needs to verify how to check the subItem is the same
        if ($originalSubItem == $newSubItem) {
            return true;
        }
        return false;
    }
}