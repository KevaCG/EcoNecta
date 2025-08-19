<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessingPlant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'location',
    ];

    public function processingLogs()
    {
        return $this->hasMany(ProcessingLog::class);
    }
}
