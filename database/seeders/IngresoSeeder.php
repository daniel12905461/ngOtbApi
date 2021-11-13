<?php

namespace Database\Seeders;

use App\Models\Ingreso;
use Illuminate\Database\Seeder;

class IngresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ingreso::create([
            'fecha' => '2021-9-01', // todo Aqui esta mal hay que cambiar tipos por ejemplo fecha
            'mes' => 'hoy',
            'concepto' => 'por agua',
            'monto_importe' => '20',
            'descripcion' => '',
            'pagado' => 0,
            'tipo_moneda_id' => 1,
            'cuenta_egresos_id' => 1,
            'parcel_id' => 1,
            'member_id' => null,
            'lectura_id' => 1,
            'mes_id' => 4,
        ]);
    }
}
