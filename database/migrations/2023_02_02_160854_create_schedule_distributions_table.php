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
        Schema::create('schedule_distributions', function (Blueprint $table) {
            $table->id();
            $table->integer('fuel_station_id');
            $table->dateTime('scheduled_date_time');
            $table->double('quota')->default(0); //In liters;
            $table->integer('status')->default(1); //1 = Pending, 2 = Recieved, 3 = Not Recieved
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
        Schema::dropIfExists('schedule_distributions');
    }
};
