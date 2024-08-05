<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'user_id',
        'start_date',
        'duration_days',
        'total_price',

    ];

    // Define relationships
    protected $casts = [
        'start_date' => 'datetime', // Cast to Carbon instance
        'total_price' => 'decimal:2', // Ensure total_price is handled as a decimal
    ];
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
