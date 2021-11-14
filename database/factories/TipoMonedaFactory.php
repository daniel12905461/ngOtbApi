<?php

namespace Database\Factories;

use App\Models\TipoMoneda;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoMonedaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TipoMoneda::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->randomElements(['Bolivianos','Dolares estadounidences'])[0],
            'abreviatura' => $this->faker->unique()->randomElements(['BS','USD'])[0],
           'activo' => 1,
           'updated_at' => now(),

        ];
    }
}
