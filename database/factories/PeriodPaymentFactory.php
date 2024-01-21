<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\PaymentRecord;
use App\Models\PeriodPayment;
use App\Models\PeriodPaymentPayer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PeriodPaymentFactory extends Factory
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
            'cron_expression' => $this->faker->randomElement([
                '0 0 * * *',
                '0 0 1 * *',
                '0 0 1 1 *',
                '0 0 1 1 1',
            ]),
            'last_run' => null,
        ];
    }
    /**
     * Configure the factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (PeriodPayment $periodPayment) {
            PeriodPaymentPayer::factory()
                ->count(rand(1, 7))
                ->create(['period_payment_id' => $periodPayment->id]);
        });
    }
}
