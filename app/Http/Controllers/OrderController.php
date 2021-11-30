<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

require_once(public_path() ."/shared/component.php");

class OrderController extends Controller
{
    public function checkout() {
        // Check Customer information in Section
        $customerId = 1;
        $note = "test to save";
        // Save to orders table
        // Save to order_products table (Retrive summary field)
        // Save to order_sub_sides table
        // Save to order_sub_entrees table
        // Save to order_sub_drinks table
        // Save to order_drinks table
        // Save to order_sides table
        // Save to order_entrees table

        $exception = DB::transaction(function() use ($customerId, $note) {
            try {
                if (Session::has('cart')){
                    $elements = "";
                    $items = array();
                    $totalQuantity = 0;
                    $totalPrice = 0;
                    $subItems = array();
                    foreach (Session::get('cart') as $key=>$value) {
                        if ($key == 'totalQuantity') {
                            $totalQuantity = $value;
                        }
                        if ($key == 'totalPrice') {
                            $totalPrice = $value;
                        }
                        if ($key == 'items') {
                            $items = $value;
                        }
                    }

                    // Save to orders table
                    $orderId = $this->saveOrderTable($customerId, $totalQuantity, $totalPrice, $note);

                    $keys = array_keys($items);
                    foreach ($keys as $key) {   // $key is serialNumber
                        $product = $items[$key]['item'];
                        $quantity = $items[$key]['quantity'];
                        $subItems = $items[$key]['subItems'];
                        $totalPricePerItem = $items[$key]['totalPricePerItem'];

                        // Save to order_products table
                        $summary = $this->retrieveProductSummary($product, $subItems, $totalPricePerItem);
                        $orderProductId = $this->saveOrderProductsTable($orderId, $product->id, $quantity, $summary);

                        // Save to subItems tables
                        $this->saveSubItems($orderProductId, $subItems);
                    }
                }
            } catch (Exception $e) {
                return $e;
            }
        });
        return is_null($exception) ? true : false;
    }

    protected function saveOrderTable($customerId, $quantity, $total, $note) {
        $orderId = DB::table('orders')->insertGetId([
            'customer_id'=>$customerId, 'quantity'=>$quantity, 'total'=>$total, 'note'=>$note, 'order_at'=>Carbon::now() 
        ]);
        return $orderId;
    }

    protected function retrieveProductSummary($product, $subItems, $totalPricePerItem) {
        $productSummary = "";
        $subItemsSummary = retrieveSummary($subItems);
        $totalPriceDisplay = retrieveTotalPriceDisplay($product, $subItems, $totalPricePerItem);

        $productSummary .= $product->name ." (" .$product->description .")\n";
        if ($subItemsSummary != "") {
            $productSummary .= $subItemsSummary ."\n";
        }    
        $productSummary .= $totalPriceDisplay;
        return $productSummary;
    }

    protected function saveOrderProductsTable($orderId, $productId, $quantity, $summary) {
        $orderProductId = DB::table('order_products')->insertGetId([
            'order_id'=>$orderId, 'product_id'=>$productId, 'quantity'=>$quantity, 'summary'=>$summary
        ]);
        return $orderProductId;
    }

    protected function saveSubItems($orderProductId, $subItems) {
        if (($subItems == null) || count($subItems) == 0) {
            return;
        }

        $keys = array_keys($subItems);
        foreach ($keys as $key) {         
            $category = $subItems[$key]['category'];
            $quantity = $subItems[$key]['quantity'];
            $item = $subItems[$key]['item'];
            
            if ($category == "Side") {
                if (count($keys) > 1) { // This means combo not Individual Side/Entree                     
                    // Save to order_sub_sides table
                    DB::table('order_sub_sides')->insert([
                        'order_product_id'=>$orderProductId, 'quantity'=>$quantity, 'side_id'=>$item->id 
                    ]);
                } else {
                    // Save to order_sides table
                    DB::table('order_sides')->insert([
                        'order_product_id'=>$orderProductId, 'side_id'=>$item->id 
                    ]);
                } 
            }
            if ($category == "Entree") {
                if (count($keys) > 1) { // This means combo not Individual Side/Entree 
                    // Save to order_sub_entrees table
                    DB::table('order_sub_entrees')->insert([
                        'order_product_id'=>$orderProductId, 'quantity'=>$quantity, 'entree_id'=>$item->id 
                    ]);
                } else {
                    // Save to order_entrees table
                    DB::table('order_entrees')->insert([
                        'order_product_id'=>$orderProductId, 'entree_id'=>$item->id 
                    ]);
                }
            }
            if ($category == "Drink") {
                // Save to order_sub_drinks table
                $typeId = null;
                if (array_key_exists('selectDrink', $subItems[$key])) {
                     $selectDrink = $subItems[$key]['selectDrink'];
                     $typeId = $selectDrink->id;
                }
                DB::table('order_sub_drinks')->insert([
                    'order_product_id'=>$orderProductId, 'quantity'=>$quantity, 'drink_id'=>$item->id, 'type_id'=>$typeId
                ]);  
            }
            if ($category == "DrinkOnly") {
                // Save to order_drinks table
                $typeId = null;
                if (array_key_exists('selectDrink', $subItems[$key])) {
                     $selectDrink = $subItems[$key]['selectDrink'];
                     $typeId = $selectDrink->id;
                }
                DB::table('order_drinks')->insert([
                    'order_product_id'=>$orderProductId, 'drink_id'=>$item->id, 'type_id'=>$typeId
                ]);
            }
        }
    }
}
