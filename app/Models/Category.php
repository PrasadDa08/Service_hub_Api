<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['name', 'icon', 'created_at', 'updated_at'])]

class Category extends Model
{
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
