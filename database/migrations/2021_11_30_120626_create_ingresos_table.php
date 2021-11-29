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
            $table->id();
            $table->timestamp('fecha')->nullable();
            // $table->string('mes')->nullable();
            $table->string('concepto')->nullable();
            $table->double('monto_importe')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('pagado')->nullable();

            $table->unsignedBigInteger('tipo_moneda_id')->nullable();
            $table->foreign('tipo_moneda_id')->references('id')->on('tipo_monedas');

            $table->unsignedBigInteger('cuenta_ingresos_id')->nullable();
            $table->foreign('cuenta_ingresos_id')->references('id')->on('cuenta_ingresos');
            // $table->integer('parcel_id')->unsigned()->nullable()->index();

            $table->unsignedBigInteger('member_id')->nullable();
//            $table->foreign('lectura_id')->references('id')->on('lecturas');

            $table->unsignedBigInteger('lectura_id')->nullable();
//            $table->foreign('lectura_id')->references('id')->on('lecturas');

            $table->unsignedBigInteger('parcel_id')->unsigned()->nullable();
            $table->foreign('parcel_id')->references('id')->on('parcels');

            $table->unsignedBigInteger('mes_id')->unsigned()->nullable();
            $table->foreign('mes_id')->references('id')->on('mes');

            $table->unsignedBigInteger('multa_id')->unsigned()->nullable();
            $table->foreign('multa_id')->references('id')->on('multas')->onDelete('cascade');;

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
