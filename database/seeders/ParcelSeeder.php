<?php

namespace Database\Seeders;

use App\Models\Parcel;
use Illuminate\Database\Seeder;

class ParcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parcel::create([
            'latitude' => '5665',
            'length' => '5665s',
            'ultimalectura' => '555',
            'enabled' => 1,
            'member_id' => 5,
        ]);
    }
}
