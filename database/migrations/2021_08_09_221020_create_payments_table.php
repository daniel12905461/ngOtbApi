<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('previous_reading');
            $table->string('current_reading')->nullable();
            $table->string('cubic_meters')->nullable();
            $table->boolean('pagado');
            $table->string('total_price')->nullable();
            $table->boolean('enabled');
            $table->unsignedBigInteger('parcel_id');
            $table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade');
            $table->unsignedBigInteger('monthly_payment_id');
            $table->foreign('monthly_payment_id')->references('id')->on('monthly_payments')->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
}
