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
            $table->increments('id');
            $table->string('lecturaActual')->nullable();
            $table->string('lecturaAnterior')->nullable();
            $table->string('cubos')->nullable();
            $table->string('cubosExeso')->nullable();
            $table->string('total')->nullable();
            $table->dateTime('fecha')->nullable();
            $table->boolean('lecturado')->nullable();
            $table->integer('mes_id')->unsigned()->nullable()->index();
            $table->integer('parcel_id')->unsigned()->nullable()->index();
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
