<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider() {
        return $this->belongsTo(Provider::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function payment(){
        return $this->belongsTo(Payment::class);
    }

    public function review(){
        return $this->hasOne(Review::class);
    }
}
