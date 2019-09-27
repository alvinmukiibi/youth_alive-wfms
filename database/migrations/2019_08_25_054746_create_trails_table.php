<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trails', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('request_id');

            $table->unsignedBigInteger('requestor_id');
            $table->boolean('accountant_approval')->default(false)->nullable();
            $table->unsignedBigInteger('accountant_id')->nullable();
            $table->text('accountant_comments')->nullable();
            $table->string('accountant_approval_date')->nullable();

            $table->boolean('level_one_approval')->default(false)->nullable();
            $table->unsignedBigInteger('level_one_approver_id')->nullable();
            $table->text('level_one_approver_comments')->nullable();
            $table->string('level_one_approval_date')->nullable();

            $table->boolean('finance_approval')->default(false)->nullable();
            $table->unsignedBigInteger('finance_approver_id')->nullable();
            $table->text('finance_approver_comments')->nullable();
            $table->string('finance_approval_date')->nullable();

            $table->boolean('level_two_approval')->default(false)->nullable();
            $table->unsignedBigInteger('level_two_approver_id')->nullable();
            $table->text('level_two_approver_comments')->nullable();
            $table->string('level_two_approval_date')->nullable();

            $table->boolean('level_three_approval')->default(false)->nullable();
            $table->unsignedBigInteger('level_three_approver_id')->nullable();
            $table->text('level_three_approver_comments')->nullable();
            $table->string('level_three_approval_date')->nullable();

            $table->foreign('request_id')->references('id')->on('program_requests');
            $table->foreign('requestor_id')->references('id')->on('users');
            $table->foreign('accountant_id')->references('id')->on('users');
            $table->foreign('level_one_approver_id')->references('id')->on('users');
            $table->foreign('finance_approver_id')->references('id')->on('users');
            $table->foreign('level_two_approver_id')->references('id')->on('users');
            $table->foreign('level_three_approver_id')->references('id')->on('users');

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
        Schema::dropIfExists('trails');
    }
}
