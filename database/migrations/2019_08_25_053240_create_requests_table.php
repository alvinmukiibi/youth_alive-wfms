<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identity', '8');
            $table->string('delivery_date');
            $table->string('activity_type');

            $table->string('attachment_prefix')->nullable();

            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('project_id')->references('id')->on('projects');
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
        Schema::dropIfExists('requests');
    }
}
