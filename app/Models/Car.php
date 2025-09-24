<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        // Basic info
        'name',
        'make',
        'model',
        'year',
        'mileage',
        'price',
        'description',
        'image',
        'status',
        'availability',

        // Specs
        'engine_size',
        'fuel_type',
        'horse_power',
        'transmission',
        'drive',

        // Optional / tracking
        'views',
        'inquiries',
        'user_id',

        // JSON / structured fields
        'specification',
        'running_Cost',

        // Origin info
        'origin', // 'import' or 'kenya'
        'source', // dealer or origin details, e.g., 'Nairobi Auto Mart'
    ];

    protected $casts = [
        'specification' => 'array',
        'running_Cost'  => 'array',
    ];

    // Relation: a car belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
