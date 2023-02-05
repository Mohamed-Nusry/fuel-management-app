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
        Schema::create('vehicle_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('reg_id')->nullable();
            $table->integer('customer_id');
            $table->integer('vehicle_id');
            $table->string('email')->unique();
            $table->string('vehicle_registration_number')->unique();
            $table->string('chassis_no')->unique();
            $table->double('total_quota')->default(0); //In liters
            $table->double('available_quota')->default(0); //In liters
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
        Schema::dropIfExists('vehicle_registrations');
    }
};
