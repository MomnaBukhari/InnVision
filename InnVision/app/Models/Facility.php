<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    // Relations


    // Many to many relation between Branches and Facility
    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }

    // Many to many relation between Rooms and Facility
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_facilities');
    }


}
