<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        // Basic info
        'name',
        'make',
        'model',
        'year',
        'mileage',
        'price',
        'description',
        'status',
        'availability',
        'car_type',   // NEW: e.g., SUV, Sedan, Truck

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

        // Media & reports
        'image',      // first/main image
        'images',     // all uploaded images (JSON)
        'report',     // PDF report path

        // JSON / structured fields
        'specification',
        'running_cost',

        // Origin info
        'origin',     // 'kenya' or 'import'
        'source',     // dealer/source info
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'specification' => 'array',
        'running_cost'  => 'array',
        'images'        => 'array',  // all uploaded images
        'year'          => 'integer',
        'mileage'       => 'integer',
        'price'         => 'decimal:2',
    ];

    /**
     * Relation: a car belongs to a user
     */
    // In your Car model

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor: Get main image URL
     */
    public function getMainImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Accessor: Get all image URLs
     */
    public function getImageUrlsAttribute()
    {
        if ($this->images && is_array($this->images)) {
            return array_map(fn($img) => asset('storage/' . $img), $this->images);
        }
        return [];
    }

    /**
     * Accessor: Get report URL
     */
    public function getReportUrlAttribute()
    {
        return $this->report ? asset('storage/' . $this->report) : null;
    }
}
