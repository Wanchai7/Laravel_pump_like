<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'user_id'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
            return $this->image_path;
        }
        return asset('storage/' . $this->image_path);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
