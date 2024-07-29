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

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'room_facilities');
    }
    public function bookedBy()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }

}
