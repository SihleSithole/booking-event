<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $primaryKey = 'event_id';
    //
    protected $fillable = [
        'name',            // Event name
        'description',     // Event description
        'location',        // Event location
        'date',            // Event date
        'time',            // Event time
        'max_attendees',   // Max number of attendees
        'ticket_price',    // Ticket price
        'status',          // Event status
        'visibility',      // Event visibility
        'categories_id',     // Foreign key to category
        'user_id',         // Foreign key to user (organizer)
    ];


    public function category()
    {
        return $this->belongsTo(Categories::class , 'categories_id');
    }

    public function organiser()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

}
