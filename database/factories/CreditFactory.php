<?php

namespace Database\Factories;

use App\Models\Payer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class CreditFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'payer_id' => Payer::inRandomOrder()->first()->id,
            'amount' => $this->faker->randomFloat(0, -250, 250),
            'description' => $this->faker->sentence(3),
        ];
    }

}
