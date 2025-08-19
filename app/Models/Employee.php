<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'locality_id',
        'assigned_waste_types',
    ];

    protected $casts = [
        'assigned_waste_types' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function locality()
    {
        return $this->belongsTo(Locality::class);
    }

    public function collectionLogs()
    {
        return $this->hasMany(CollectionLog::class);
    }
}
