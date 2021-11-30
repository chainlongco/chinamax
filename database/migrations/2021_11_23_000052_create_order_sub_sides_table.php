<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSubSidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_sub_sides', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_product_id')->unsigned();
            $table->foreign('order_product_id')->references('id')->on('order_products')->onDelete('cascade');
            $table->bigInteger('side_id')->unsigned();
            $table->foreign('side_id')->references('id')->on('sides')->onDelete('cascade');
            $table->float('quantity', 4, 2);
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
        Schema::dropIfExists('order_sub_sides');
    }
}
