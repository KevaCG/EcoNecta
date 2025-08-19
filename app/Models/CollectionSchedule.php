<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'locality_id',
        'waste_type_id',
        'day_of_week',
        'frequency',
        'is_automatic',
        'is_active',
    ];

    public function locality()
    {
        return $this->belongsTo(Locality::class);
    }

    public function wasteType()
    {
        return $this->belongsTo(WasteType::class);
    }

    public function collectionLogs()
    {
        return $this->hasMany(CollectionLog::class, 'schedule_id');
    }
}
