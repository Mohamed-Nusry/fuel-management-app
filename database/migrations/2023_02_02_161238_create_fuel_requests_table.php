<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('fuel_station_id');
            $table->integer('vehicle_registration_id');
            $table->integer('vehicle_id')->nullable();
            $table->double('requested_quota')->default(0); //In liters
            $table->dateTime('expected_date_time');
            $table->integer('status')->default(1); //1 = Pending, 2 = Accepted, 3 = Rejected due to customer issue, 4 = Rejected due to fuel issue, 5 = Rescheduled
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
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
        Schema::dropIfExists('fuel_requests');
    }
};
