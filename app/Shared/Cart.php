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
        $newItemSerialNumber = $this->serialNumber+1;
        //if ($subItem) {
            $storedItem = ['item'=>$item, 'subItem'=>$subItem, 'quantity'=>$quantity];
        //} else {
        //    $storedItem = ['item'=>$item, 'quantity'=>$quantity];
        //}
       
        /*if (array_key_exists($id, $this->products)) {
            if ($subItem == null) { // Appetizers - this can be merged
                
            } else {    // Like all products from menu except Appetizers
                $sericalNumber++;
            }
        } else {
            $serialNumber++;
        }*/
        $this->items[$newItemSerialNumber] = $storedItem;
        $this->totalQuantity += $quantity;
        $this->totalPrice += ((double)($item->price) * $quantity);
        $this->serialNumber = $newItemSerialNumber;
    }
}