<?php

namespace Database\Factories;

use App\Models\Payer;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayerFactory extends Factory
{
    protected $model = Payer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ];
    }
}
