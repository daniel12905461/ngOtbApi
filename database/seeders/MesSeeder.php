<?php

namespace Database\Seeders;

use App\Models\Mes;
use Illuminate\Database\Seeder;

class MesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mes::create([
            'name' => 'Enero',
            'year' => '2021',
            'enabled' => 0,
        ]);
        Mes::create([
            'name' => 'Febrero',
            'year' => '2021',
            'enabled' => 0,
        ]);
        Mes::create([
            'name' => 'Marzo',
            'year' => '2021',
            'enabled' => 0,
        ]);
        Mes::create([
            'name' => 'Abril',
            'year' => '2021',
            'enabled' => 1,
        ]);
    }
}
