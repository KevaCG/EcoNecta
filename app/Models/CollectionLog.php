<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'employee_id',
        'waste_type_id',
        'quantity_kg',
        'status',
        'collection_date',
    ];

    protected $casts = [
        'collection_date' => 'datetime',
    ];

    public function collectionSchedule()
    {
        return $this->belongsTo(CollectionSchedule::class, 'schedule_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function wasteType()
    {
        return $this->belongsTo(WasteType::class);
    }
}
