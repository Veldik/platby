<?php

use App\Models\Payer;
use App\Models\PeriodPayment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('period_payment_payers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PeriodPayment::class);
            $table->foreignIdFor(Payer::class);
            $table->float('amount');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('period_payment_payers');
    }
};
