<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('period_payments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('cron_expression');
            $table->timestamp('last_run')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('period_payments');
    }
};
