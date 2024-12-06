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

        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');  // Auto-incrementing primary key (ID)
            $table->string('name');  // Event name
            $table->text('description');  // Event description
            $table->string('location');  // Event location
            $table->date('date');  // Event date
            $table->time('time');  // Event time
            $table->foreignIdFor(\App\Models\Categories::class);
            $table->foreignIdFor(\App\Models\User::class);  // Organizer ID with foreign key (assumes 'users' table exists)
            $table->integer('max_attendees');  // Max number of attendees for the event
            $table->decimal('ticket_price', 8, 2)->default(0.00);  // Ticket price with default value of 0.00
            $table->string('status');  // Event status
            $table->string('visibility');  // Event visibility
            $table->timestamps();  // Created at and Updated at

        });

    }

    //id, name, description, location, date, time, category_id, organizer_id, max_attendees, ticket_price, status, visibility, etc.

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
