<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    //

    protected $fillable = [
        'event_id',
        'user_id',
        'rating',
        'review_text',

    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //id, event_id, user_id, rating, review_text, created_at
}
