<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_facilities');
    }
}
