<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointExchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'points_redeemed',
        'coupon_code',
        'discount_applied',
        'exchange_date',
    ];

    protected $casts = [
        'exchange_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
