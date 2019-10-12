<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesheetStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheet_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('timesheet_id');

            $table->integer('scheduled_hours')->default(0);
            $table->integer('worked_hours')->default(0);
            $table->integer('overtime_hours')->default(0);
            $table->integer('total_hours_worked')->default(0);
            $table->integer('percentage_time')->default(0);

            $table->foreign('timesheet_id')->references('id')->on('timesheets')->onDelete('cascade');
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
        Schema::dropIfExists('timesheet_statistics');
    }
}
