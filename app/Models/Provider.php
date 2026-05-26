<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id','experience', 'bio', 'is_verified', 'longitude', 'latitude', 'created_at', 'updated_at'])]

class Provider extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services() {
        return $this->belongsToMany(Service::class, 'provider_services')->withPivot('custom_price')->withTimestamps();
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
