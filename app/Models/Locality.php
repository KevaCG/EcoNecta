<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'postal_code',
        'collection_days',
    ];

    protected $casts = [
        'collection_days' => 'array',
    ];

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function collectionSchedules()
    {
        return $this->hasMany(CollectionSchedule::class);
    }
}
