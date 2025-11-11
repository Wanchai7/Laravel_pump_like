<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'status',
        'total',
        'hidden_from_admin',
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
