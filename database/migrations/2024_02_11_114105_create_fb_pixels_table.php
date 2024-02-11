<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFbPixelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fb_pixels', function (Blueprint $table) {
            $table->id();
            $table->text('pixel_code')->nullable();
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
        Schema::dropIfExists('fb_pixels');
    }
}
