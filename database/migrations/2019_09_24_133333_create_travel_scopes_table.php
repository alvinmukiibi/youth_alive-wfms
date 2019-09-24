<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelScopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_scopes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('travellers')->nullable();
            $table->string('date_of_activity')->nullable();
            $table->text('destination')->nullable();
            $table->string('departure_point')->nullable();
            $table->string('departure_date')->nullable();
            $table->string('return_date')->nullable();
            $table->text('objectives')->nullable();
            $table->text('activities')->nullable();
            $table->text('key_people_to_be_met')->nullable();
            $table->text('expected_deliverables')->nullable();
            $table->text('misc_notes')->nullable();

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
        Schema::dropIfExists('travel_scopes');
    }
}
