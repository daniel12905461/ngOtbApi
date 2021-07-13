<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "dad_last_name" => $this->faker->lastName,
            "mom_last_name" => $this->faker->lastName,
            "dir_foto" => $this->faker->imageUrl(),
            "ci" => $this->faker->randomNumber(9),
            "phone" => $this->faker->randomNumber(8),
            "birth_date" => $this->faker->dateTime,
            "enabled" => 1
        ];
    }
}
