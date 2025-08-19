<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'locality_id',
        'baldes_aserrin_available',
        'minimum_stock',
    ];

    public function locality()
    {
        return $this->belongsTo(Locality::class);
    }
}
