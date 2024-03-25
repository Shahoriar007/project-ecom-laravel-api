<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeSubAndChildCategoryNullableInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_category_id')->nullable()->change()->comment('from sub categories table');
            $table->unsignedBigInteger('child_category_id')->nullable()->change()->comment('from child categories table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_category_id')->change()->comment('from sub categories table');
            $table->unsignedBigInteger('child_category_id')->change()->comment('from child categories table');
        });
    }
}
