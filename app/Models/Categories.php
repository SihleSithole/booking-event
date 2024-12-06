<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Categories extends Model
{

    //use HasFactory, Notifiable;

    protected $fillable = [
        'name',            // categories name
        'description',
        'id', // categories description

    ];

 /*   public function events()
    {
        return $this->hasMany(Event::class);
    } */

}
