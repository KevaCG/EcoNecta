<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'subcategory',
        'points_per_kg',
        'collection_frequency',
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_waste_type');
    }

    public function collectionLogs()
    {
        return $this->hasMany(CollectionLog::class);
    }
}
