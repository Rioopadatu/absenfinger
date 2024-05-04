<?php

namespace Database\Factories;

use App\Models\FpUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class FpUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FpUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'userid' => $this->faker->word,
        'name' => $this->faker->word,
        'role' => $this->faker->randomDigitNotNull,
        'password' => $this->faker->word,
        'cardno' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
