<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSubEntreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_sub_entrees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_product_id')->unsigned();
            $table->foreign('order_product_id')->references('id')->on('order_products')->onDelete('cascade');
            $table->bigInteger('entree_id')->unsigned();
            $table->foreign('entree_id')->references('id')->on('entrees')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_sub_entrees');
    }
}
