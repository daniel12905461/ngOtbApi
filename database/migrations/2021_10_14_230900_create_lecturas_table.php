<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturas', function (Blueprint $table) {
            $table->id();
            $table->string('lecturaActual')->nullable();
            $table->string('lecturaAnterior')->nullable();
            $table->string('cubos')->nullable();
            $table->string('cubosExeso')->nullable();
            $table->string('total')->nullable();
            $table->dateTime('fecha')->nullable();
            $table->boolean('lecturado')->nullable();

            $table->unsignedBigInteger('parcel_id')->nullable();
            $table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade');

            $table->unsignedBigInteger('mes_id');
            $table->foreign('mes_id')->references('id')->on('mes')->onDelete('cascade');
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
        Schema::dropIfExists('lecturas');
    }
}
