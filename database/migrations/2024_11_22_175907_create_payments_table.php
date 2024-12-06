<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Bookings::class);
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->string('payment_method');
            $table->string('payment_status');
            $table->timestamps();
        });
    }
//id, booking_id, amount, payment_method, payment_status
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
