<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'otp',
    ];

    // I used this to define the table name explicitly
    protected $table = 'otps';
}
