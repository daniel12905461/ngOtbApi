<?php

namespace Database\Seeders;

use App\Models\Lectura;
use Illuminate\Database\Seeder;

class LecturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lectura::create([
            'lecturaActual' => '5665',
            'lecturaAnterior' => '5650',
            'cubos' => '15',
            'cubosExeso' => '0',
            'fecha' => now(),
            'lecturado' => 1,
            'parcel_id' => 1,
            'mes_id' => 4,
        ]);
    }
}
