<?php

namespace Database\Factories;

use App\Models\Payer;
use App\Models\PeriodPayment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentRecord>
 */
class PeriodPaymentPayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'period_payment_id' => PeriodPayment::inRandomOrder()->first()->id,
            'payer_id' => Payer::inRandomOrder()->first()->id,
            'amount' => $this->faker->randomFloat(0, 0, 250),
        ];
    }
}
