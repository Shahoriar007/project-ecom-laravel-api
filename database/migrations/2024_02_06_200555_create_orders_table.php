<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->integer('quantity');
            $table->decimal('amount', 9, 2);
            $table->decimal('delivery_charge', 9, 2);
            $table->decimal('vat', 9, 2)->default(0);
            $table->decimal('tax', 9, 2)->default(0);
            $table->decimal('discount', 9, 2)->default(0);
            $table->decimal('total_amount', 9, 2);
            $table->string('delivery_address');
            $table->enum('payment_method', ['cash_on_delivery', 'online_payment'])->default('cash_on_delivery');
            $table->enum('status', ['pending', 'processing', 'packing', 'shipping', 'on_the_way', 'in_review', 'rejected', 'returned', 'canceled', 'delivered'])->default('pending');
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
        Schema::dropIfExists('orders');
    }
}
