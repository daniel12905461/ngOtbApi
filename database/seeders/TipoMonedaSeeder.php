<?php

namespace Database\Seeders;

use App\Models\TipoMoneda;
use Illuminate\Database\Seeder;

class TipoMonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoMoneda::factory()->count(2)->create();
    }
}
