<?php

use App\Models\Event;
use App\Models\User;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Event::class);
            $table->date('booking_date');  // Event date
            $table->string('payment_status');  // Event date
            $table->string('qr_code');  // Event date
            $table->timestamps();
        });
        //id, user_id, event_id, booking_date, payment_status, QR_code, etc.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
