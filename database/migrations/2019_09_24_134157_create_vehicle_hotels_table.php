<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_hotels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('vehicle')->default(0);
            $table->boolean('hotel')->default(0);
            $table->text('purpose')->nullable();
            $table->string('departure_date')->nullable();
            $table->string('return_date')->nullable();
            $table->string('departure_venue')->nullable();
            $table->text('reason')->nullable();
            $table->text('name_of_passengers')->nullable();

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
        Schema::dropIfExists('vehicle_hotels');
    }
}
