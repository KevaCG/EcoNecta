<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'plant_id',
        'waste_type_id',
        'quantity_kg',
        'entry_date',
    ];

    protected $casts = [
        'entry_date' => 'datetime',
    ];

    public function processingPlant()
    {
        return $this->belongsTo(ProcessingPlant::class, 'plant_id');
    }

    public function wasteType()
    {
        return $this->belongsTo(WasteType::class);
    }
}
