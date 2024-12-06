<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    //

    protected $fillable = [
        'bookings_booking_id',
        'amount',
        'payment_method',
        'payment_status',

    ];

    //id, booking_id, amount, payment_method, payment_status

    public function booking()
    {
        return $this->belongsTo(Bookings::class);
    }

}
