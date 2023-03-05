<?php

namespace Database\Seeders;

use App\Models\Payer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payer::factory()
            ->count(25)
            ->create();
    }
}
