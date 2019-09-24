<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identity')->unique();
            $table->string('activity_type');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->text('documents')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_requests');
    }
}
