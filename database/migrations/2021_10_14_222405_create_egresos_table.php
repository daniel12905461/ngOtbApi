<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('fecha')->nullable();
            $table->string('mes')->nullable();
            $table->string('concepto')->nullable();
            $table->string('monto_importe')->nullable();
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('tipo_moneda_id')->unsigned()->nullable()->index();
            $table->unsignedBigInteger('cuenta_egresos_id')->unsigned()->nullable()->index();
            $table->unsignedBigInteger('mes_id')->unsigned()->nullable()->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('egresos');
    }
}
