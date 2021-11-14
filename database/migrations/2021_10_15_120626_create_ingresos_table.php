<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fecha')->nullable();
            // $table->string('mes')->nullable();
            $table->string('concepto')->nullable();
            $table->double('monto_importe')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('pagado')->nullable();
            $table->integer('tipo_moneda_id')->unsigned()->nullable()->index();
            $table->integer('cuenta_egresos_id')->unsigned()->nullable()->index();
            // $table->integer('parcel_id')->unsigned()->nullable()->index();
            $table->integer('menber_id')->unsigned()->nullable()->index();
            $table->integer('lectura_id')->unsigned()->nullable()->index();
            $table->integer('parcel_id')->unsigned()->nullable();
            $table->foreign('parcel_id')->references('id')->on('parcels');
            $table->integer('mes_id')->unsigned()->nullable();
            $table->foreign('mes_id')->references('id')->on('mes');
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
        Schema::drop('ingresos');
    }
}
