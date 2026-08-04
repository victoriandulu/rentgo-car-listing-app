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
        'variant',        // ← NEW: e.g. "Vx-L 2.8gd Auto"
        'year',
        'mileage',
        'price',
        'description',
        'status',
        'availability',
        'car_type',
        'seats',          // ← NEW: e.g. 7
        'doors',          // ← NEW: e.g. 5

        // Specs
        'engine_size',
        'fuel_type',
        'fuel_consumption',   // ← NEW: e.g. "7.9 l/100km"
        'fuel_tank_capacity', // ← NEW: e.g. "150 l"
        'cylinder_layout',    // ← NEW: e.g. "I4"
        'kilowatts',          // ← NEW: e.g. "150 kW"
        'gears',               // ← NEW: e.g. "6"
        'horse_power',
        'transmission',
        'torque',
        'aspiration',
        'acceleration',
        'drive',

        // Tracking
        'views',
        'inquiries',
        'user_id',
        'location',

        // Media & reports
        'image',          // main/first image path
        'images',         // all uploaded images (JSON array)
        'video',          // ← video walkthrough path  e.g. car-videos/abc.mp4
        'report',         // PDF report path
        'report_price',   // price buyer pays to unlock report

        // JSON / structured fields
        'specification',
        'running_cost',

        // Origin info
        'origin',         // 'kenya' or 'import'
        'source',         // dealer / source info
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'specification' => 'array',
        'running_cost'  => 'array',
        'images'        => 'array',
        'year'          => 'integer',
        'mileage'       => 'integer',
        'seats'         => 'integer',
        'doors'         => 'integer',
        'price'         => 'decimal:2',
        'report_price'  => 'decimal:2',
    ];

    /* ─────────────────────────────────────────
     * Relationships
     * ───────────────────────────────────────── */

    /**
     * A car belongs to a user (the seller).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* ─────────────────────────────────────────
     * Accessors
     * ───────────────────────────────────────── */

    /**
     * Full URL of the main/first image.
     * Returns null when no image is stored.
     */
    public function getMainImageUrlAttribute(): ?string
    {
        return $this->image
            ? asset('storage/' . ltrim($this->image, '/'))
            : null;
    }

    /**
     * Array of full URLs for all uploaded images.
     * Returns an empty array when none are stored.
     */
    public function getImageUrlsAttribute(): array
    {
        if (empty($this->images) || !is_array($this->images)) {
            return [];
        }

        return array_values(
            array_filter(
                array_map(
                    fn($img) => $img ? asset('storage/' . ltrim($img, '/')) : null,
                    $this->images
                )
            )
        );
    }

    /**
     * Full URL of the video walkthrough.
     * Returns null when no video is stored.
     */
    public function getVideoUrlAttribute(): ?string
    {
        $raw = trim((string) ($this->video ?? ''));

        if ($raw === '' || $raw === 'null') {
            return null;
        }

        return asset('storage/' . ltrim($raw, '/'));
    }

    /**
     * Whether this car has a video walkthrough.
     * Safe to call as $car->has_video in Blade.
     */
    public function getHasVideoAttribute(): bool
    {
        $raw = trim((string) ($this->video ?? ''));
        return $raw !== '' && $raw !== 'null';
    }

    /**
     * Full URL of the inspection report PDF.
     * Returns null when no report is stored.
     */
    public function getReportUrlAttribute(): ?string
    {
        return $this->report
            ? asset('storage/' . ltrim($this->report, '/'))
            : null;
    }
}
