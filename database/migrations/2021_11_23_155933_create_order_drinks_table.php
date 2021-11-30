<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDrinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_drinks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_product_id')->unsigned();
            $table->foreign('order_product_id')->references('id')->on('order_products')->onDelete('cascade');
            $table->bigInteger('drink_id')->unsigned();
            $table->foreign('drink_id')->references('id')->on('drinks')->onDelete('cascade');
            $table->bigInteger('type_id')->nullable();
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
        Schema::dropIfExists('order_drinks');
    }
}
