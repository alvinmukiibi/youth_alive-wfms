<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesheetProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheet_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('timesheet_id');
            $table->unsignedBigInteger('project_id');

            for ($i = 1; $i <= 31; $i++) {
                $table->integer($i)->nullable();
            }

            $table->foreign('timesheet_id')->references('id')->on('timesheets')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

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
        Schema::dropIfExists('timesheet_projects');
    }
}
