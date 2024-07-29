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
        'status',
        'booked_by',
        'floor',
        'max_occupancy',
        'single_beds',
        'description'
    ];


    // Relations


    // Making relation as one room belongs to one branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    // Making many to many relation with facilities,  room_facilities is table name that is pivot table
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'room_facilities');
    }


    // Defining to see Who booked room
    public function bookedBy()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }

}
