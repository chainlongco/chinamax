<?php

namespace App\Shared;
use Illuminate\Support\Facades\DB;

Class SubItem {
    public $productId = 0;
    public $category = "";
    public $elementIdPrefix = "";
    public $id = 0;
    public $quantity = 0;
    public $maxQuantity = 0;

    function __constract($productId, $category, $elementIdPrefix, $id, $quantity) {
        $this->productId = $productId;
        $this->category = $category;
        $this->elementIdPrefix = $elementIdPrefix;
        $combo = DB::table('combos')->where('productId', $productId)->first();
        if ($category == 'side') {
            $this->maxQuantity = $combo->side;
        } else if ($category == 'entree') {
            $this->maxQuantity = $combo->entree;
        }
    }






    /*public $serialNumber = 0;
    public $subItems = array(); //sericalNumber=>1, category=>"side", item=>$side, quantity=>0.5

    function __constract($oldSubItem) {
        if ($oldSubItem) {
            $this->serialNumber = $oldSubItem->serialNumber;
            $this->subItems = $oldSubItem->subItems;
        }
    }

    public function addNewSubItem($category, $item, $quantity) {
        $newSerialNubmer = ($this->serialNumber + 1);
        $this->subItem[$newSerialNumber] = ['category'=>$category, 'item'=>$item, 'quantity'=>$quantity];
        $this->serialNumber = $newSerialNumber;
    }

    public function isCategoryQuantityReady($category, $expectedQuantity) {
        $Quantity = 0;
        $keys = Array_keys($this->subItems);
        foreach ($keys as $key) {
            if ($this->subItems[$key]['category'] == $category) {
                $quantity += $this->items[$key]['quantity'];
            }
        }
        return ($quantity == $expectedQuantity);
    }*/
}    