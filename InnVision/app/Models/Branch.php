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
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
