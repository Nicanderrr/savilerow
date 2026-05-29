<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('provider')->default('paystack');
            $table->string('reference')->unique();
            $table->string('status')->default('pending');
            $table->string('currency', 3);
            $table->decimal('amount', 12, 2);
            $table->string('authorization_url')->nullable();
            $table->string('access_code')->nullable();
            $table->string('gateway_response')->nullable();
            $table->json('payload')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
