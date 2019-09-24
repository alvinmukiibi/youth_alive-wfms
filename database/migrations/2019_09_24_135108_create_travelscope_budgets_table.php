<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelscopeBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travelscope_budgets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('activity')->nullable();
            $table->string('date')->nullable();
            $table->text('destination')->nullable();
            $table->text('purpose')->nullable();
            $table->text('comments')->nullable();
            $table->integer('total')->nullable();

            $table->unsignedBigInteger('program_request_id')->nullable();
            $table->foreign('program_request_id')->references('id')->on('program_requests');

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
        Schema::dropIfExists('travelscope_budgets');
    }
}
