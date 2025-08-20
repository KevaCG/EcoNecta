<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'waste_type',
    'scheduled_date',
    'status',
    'kilos',
    'points',
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
