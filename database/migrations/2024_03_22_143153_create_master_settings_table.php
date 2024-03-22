<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_settings', function (Blueprint $table) {
            $table->id();
            $table->float('inside_dhaka', 9, 2)->comment('Delivery Charge');
            $table->float('outside_dhaka', 9, 2)->comment('Delivery Charge');
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
        Schema::dropIfExists('master_settings');
    }
}
