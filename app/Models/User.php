<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }

    public function getOrganisers()
    {
        $organisers = User::where('role', 'organiser')  // Filter users by role 'organiser'
        ->with('events.category')   // Eager load the 'events' and 'category' relationships
        ->get();

        // Dump the result to inspect
        return $organisers;

    }


}
