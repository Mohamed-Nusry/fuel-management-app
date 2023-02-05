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
        Schema::create('fuel_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token_ref')->nullable();
            $table->integer('customer_id');
            $table->integer('fuel_request_id');
            $table->string('payment_reference')->nullable();
            $table->integer('status')->default(1); //1 = Pending, 2 = Collected, 3 = Rejected, 4 = Expired, 7 = Completed
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
        Schema::dropIfExists('fuel_tokens');
    }
};
