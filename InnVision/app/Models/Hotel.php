<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'address',
        'stars',
    ];



    // Relations


    // Relation between Users(Owners) and Hotels
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }


    // Relation between Branches and Hotels
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }


}
