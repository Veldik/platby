<?php

namespace Database\Factories;

use App\Models\Credit;
use App\Models\Payer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payer>
 */
class PayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $isUser = $this->faker->boolean(50);

        $data = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
        ];

        if ($isUser) {
            User::factory()->create(
                [
                    'name' => $data['firstName'] . ' ' . $data['lastName'],
                    'email' => $data['email'],
                    'role' => 'user',
                ]
            );
        }

        return $data;
    }

    public function configure()
    {
        return $this->afterCreating(function (Payer $payer) {
            Credit::factory()
                ->count(rand(1, 10))
                ->create(['payer_id' => $payer->id]);
        });
    }
}
