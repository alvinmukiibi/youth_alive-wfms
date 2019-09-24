<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelscopeBudgetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travelscope_budget_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no');
            $table->integer('units');
            $table->integer('frequency');
            $table->integer('unit_cost');

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
        Schema::dropIfExists('travelscope_budget_items');
    }
}
