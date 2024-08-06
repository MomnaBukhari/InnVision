<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'room_number',
        'is_booked',
        'customer_id',
        'floor',
        'max_occupancy',
        'single_beds',
        'fare',
        'description'
    ];

    // Relations

    // Room belongs to one branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Many-to-many relation with facilities
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'room_facilities');
    }

    // Room can have many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Define the current booking (latest one)
    public function currentBooking()
    {
        return $this->hasOne(Booking::class)->latestOfMany();
    }

    // Get the user who booked the room (if any)
    public function bookedBy()
    {
        return $this->hasOneThrough(User::class, Booking::class, 'room_id', 'id', 'id', 'user_id');
    }

    // Check if the room is currently booked
    public function isBooked()
    {
        return $this->currentBooking()->exists();
    }
}
