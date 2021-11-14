<?php

namespace Database\Seeders;

use App\Models\CuentaIngreso;
use Illuminate\Database\Seeder;

class CuentaIngresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CuentaIngreso::create([
            'nombre' => 'Agua Potable',
            'costo' => '2',
            'activo' => '1',
        ]);
        CuentaIngreso::create([
            'nombre' => 'Agua Riego',
            'costo' => '1',
            'activo' => '1',
        ]);
    }
}
