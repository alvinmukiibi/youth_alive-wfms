<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestedAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('request_id');
            $table->string('quantity');
            $table->unsignedInteger('unit_cost');
            $table->unsignedInteger('total_cost')->nullable();
            $table->text('comments')->nullable();

            $table->foreign('request_id')->references('id')->on('requests');
            $table->foreign('asset_id')->references('id')->on('assets');

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
        Schema::dropIfExists('requested_assets');
    }
}
