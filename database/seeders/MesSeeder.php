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
            'year' => 2021,
            'index' => 1,
            'enabled' => 0,
        ]);
        Mes::create([
            'name' => 'Febrero',
            'year' => 2021,
            'index' => 2,
            'enabled' => 0,
        ]);
        Mes::create([
            'name' => 'Marzo',
            'year' => 2021,
            'index' => 3,
            'enabled' => 0,
        ]);
        Mes::create([
            'name' => 'Abril',
            'year' => 2021,
            'index' => 4,
            'enabled' => 0,
        ]);
        Mes::create([
            'name' => 'Mayo',
            'year' => 2021,
            'index' => 5,
            'enabled' => 0,
        ]);

    }
}
