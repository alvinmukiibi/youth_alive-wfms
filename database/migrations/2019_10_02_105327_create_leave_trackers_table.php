<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_trackers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->integer('sick')->default(0)->nullable();
            $table->integer('hospitalization')->default(0)->nullable();
            $table->integer('maternity')->default(0)->nullable();
            $table->integer('paternity')->default(0)->nullable();
            $table->integer('study')->default(0)->nullable();
            $table->integer('annual')->default(0)->nullable();
            $table->integer('compassionate')->default(0)->nullable();
            $table->string('year');

            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('leave_trackers');
    }
}
