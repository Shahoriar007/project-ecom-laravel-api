<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('from users table');
            $table->unsignedBigInteger('attendance_status_id')->nullable()->comment('from attendance_statuses table');
            $table->date('date');
            $table->time('first_check_in')->nullable();
            $table->integer('expected_duty_minutes')->default(0);
            $table->time('last_check_out')->nullable();
            $table->integer('total_worked_minutes')->default(0)->comment('total worked minutes');
            $table->integer('extra_less_duty_minutes')->default(0);
            // leave request
            $table->unsignedBigInteger('leave_request_id')->nullable()->comment('from leave_requests table');
            $table->unsignedBigInteger('leave_type_id')->nullable()->comment('from leave_types table');
            $table->boolean('on_leave')->default(false);
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('attendances');
    }
}
