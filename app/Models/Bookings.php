<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    //

    protected $primaryKey = 'booking_id';
    protected $fillable = [
        'user_id',
        'event_event_id',
        'booking_date',
        'payment_status',
        'qr_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function payment()
    {
        return $this->hasOne(Payments::class);
    }


    public static function showBookings()
    {

        $user = auth()->user();
        $id = $user->id;

        // Retrieve all bookings that belong to the current organizer's events
        $bookings = Bookings::with('event.organiser')  // Eager load event and organiser
        ->whereHas('event', function ($query) use ($id) {
            // Only include bookings where the event's organiser's user_id matches the current user's id
            $query->where('user_id', '=', $id);
        }) ->get();

        // Return the bookings that belong to the current organiser
        return $bookings;
    }

    public static function allBookings()
    {
        // Retrieve all bookings with their associated event and organiser
        $bookings = Bookings::with('event.organiser')  // Eager load event and organiser
        ->get();

        // Return all the bookings
        return $bookings;
    }

}
