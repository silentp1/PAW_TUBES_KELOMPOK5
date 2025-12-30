<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;

    //
    protected $guarded = ['id'];

    public function theaters()
    {
        return $this->belongsToMany(Theater::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Accessor for Poster
    public function getPosterUrlAttribute()
    {
        if (filter_var($this->poster, FILTER_VALIDATE_URL)) {
            return $this->poster;
        }
        return asset('storage/' . $this->poster);
    }
}
