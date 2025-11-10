<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusAttribute($value)
    {
        if ($value === 'pending') {
            return 'รอดำเนินการ';
        }
        return $value;
    }

    public function getStatusColorClassAttribute()
    {
        if ($this->status === 'รอดำเนินการ' || $this->status === 'pending') {
            return 'bg-yellow-500 text-yellow-900';
        }

        if ($this->status === 'ดำเนินการเสร็จเรียบร้อย') {
            return 'bg-green-500 text-green-900';
        }

        return 'bg-gray-500 text-gray-900';
    }
}
