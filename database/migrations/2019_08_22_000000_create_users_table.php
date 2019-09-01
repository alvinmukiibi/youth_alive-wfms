<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('user_name')->nullable();
            $table->string('email')->unique();
            $table->text('password')->nullable();
            $table->string('work_contact')->nullable();
            $table->string('mobile_contact');
            $table->string('home_contact')->nullable();
            $table->text('address')->nullable();
            $table->text('profile_picture')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('designation_id');
            $table->unsignedBigInteger('contract_id');
            $table->text('duty_station');
            $table->boolean('activity_status')->default(false);
            $table->boolean('email_verified_status')->default(false);
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('designation_id')->references('id')->on('designations');
            $table->foreign('contract_id')->references('id')->on('contracts');

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
