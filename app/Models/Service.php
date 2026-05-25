<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['category_id', 'name', 'description', 'base_price', 'created_at', 'updated_at'])]

class Service extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class, 'provider_services')->withPivot('custom_price')->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
