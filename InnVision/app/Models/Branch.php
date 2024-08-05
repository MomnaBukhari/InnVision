<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'name',
        'is_main',
        'address',
        'owner_id',
    ];

    // Inverse Relation of 'One Hotel have Multiple Branches' that I have defined in Hotel Model.
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }


    // Many to Many Relation of Facility and Brances.
    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }


    // Defining Relation between Owner(User) and Branches.
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }


}
