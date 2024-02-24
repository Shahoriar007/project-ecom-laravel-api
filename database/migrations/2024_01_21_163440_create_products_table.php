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
            $table->decimal('price', 9, 2);
            $table->string('sku');
            $table->integer('stock');
            $table->text('short_description');
            $table->text('offer_notice');
            $table->decimal('sale_price', 9, 2);
            $table->integer('sale_count')->default(0);
            $table->integer('ratings')->default(0);
            $table->boolean('is_hot')->default(false);
            $table->boolean('is_sale')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_out_of_stock')->default(false);
            $table->boolean('is_for_you')->default(false);
            $table->date('release_date')->nullable();
            $table->string('developer')->nullable();
            $table->string('publisher')->nullable();
            $table->boolean('rated')->default(false);
            $table->date('until')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('category_id')->comment('from categories table');
            $table->unsignedBigInteger('sub_category_id')->comment('from sub categories table');
            $table->unsignedBigInteger('child_category_id')->comment('from child categories table');
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
