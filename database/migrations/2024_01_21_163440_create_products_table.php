<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->boolean('status')->default(true);
            $table->text('description');
            $table->text('offer_notice');
            $table->decimal('regular_price', 9, 2);
            $table->decimal('sale_price', 9, 2);
            $table->integer('quantity');
            $table->string('sku_code');
            $table->boolean('is_flash_sale')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->boolean('is_hot_deal')->default(false);
            $table->boolean('is_for_you')->default(false);
            $table->unsignedBigInteger('category_id')->nullable()->comment('from categories table');
            $table->unsignedBigInteger('created_by')->nullable()->comment('from users table');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('from users table');
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
        Schema::dropIfExists('products');
    }
}
