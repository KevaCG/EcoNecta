<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'document_id',
        'phone_whatsapp',
        'address',
        'neighborhood',
        'postal_code',
        'locality',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relación con la tabla 'waste_types'.
     */
    public function wasteTypes()
    {
        return $this->belongsToMany(WasteType::class, 'user_waste_type', 'user_id', 'waste_type_id');
    }

    /**
     * Relación con la tabla 'collections'.
     */
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
