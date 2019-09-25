<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelscopeBudgetContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travelscope_budget_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('contact')->nullable();
            $table->string('position')->nullable();
            $table->integer('amount')->nullable();


            $table->unsignedBigInteger('travelscope_budget_id')->nullable();
            $table->foreign('travelscope_budget_id')->references('id')->on('travelscope_budgets');


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
        Schema::dropIfExists('travelscope_budget_contacts');
    }
}
