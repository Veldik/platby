<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\PeriodPayment;
use Illuminate\Database\Seeder;

class PeriodPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PeriodPayment::factory()
            ->count(rand(5, 15))
            ->create();
    }
}
