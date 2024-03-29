<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\PaymentRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(rand(1, 3), true),
            'description' => $this->faker->sentence(),
        ];
    }
    /**
     * Configure the factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Payment $payment) {
            PaymentRecord::factory()
                ->count(rand(1, 10))
                ->create(['payment_id' => $payment->id]);
        });
    }
}
