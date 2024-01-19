<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('designation_id')->nullable()->comment('from designations table');
            $table->unsignedBigInteger('created_by')->nullable()->comment('from users table');
            $table->unsignedBigInteger('department_id')->nullable()->comment('from departments table');

            $table->string('name')->index();
            $table->string('email')->unique();
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('status')->default(1);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
