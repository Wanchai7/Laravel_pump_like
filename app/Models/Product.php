<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'user_id'
    ];

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
