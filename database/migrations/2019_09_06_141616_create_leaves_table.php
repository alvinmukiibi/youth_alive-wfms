<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('leave_type_id');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->bigInteger('duration')->nullable();
            $table->text('comments')->nullable();
            $table->text('approval_comments')->nullable();
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->bigInteger('total_annual_days_remaining')->nullable();
            $table->bigInteger('total_annual_days_allowed')->default(21);
            $table->timestamps();

            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('leave_type_id')->references('id')->on('leave_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
