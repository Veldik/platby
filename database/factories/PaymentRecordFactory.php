<?php

namespace Database\Factories;

use App\Models\Payer;
use App\Models\Payment;
use App\Models\PaymentRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentRecord>
 */
class PaymentRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(0, 0, 250),
            'payer_id' => Payer::inRandomOrder()->first()->id,
            'payment_id' => Payment::inRandomOrder()->first()->id,
            'paid_at' => $this->faker->boolean(30) ? null : $this->faker->dateTimeBetween('-1 year', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-2 years', '-1 year'),
        ];
    }
}
