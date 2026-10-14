<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'link_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /** Only visible slides, in the order the admin chose. */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->orderBy('sort_order')
                     ->orderBy('id');
    }

    /** Public URL of the stored image (same /storage/... path car photos use). */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . ltrim((string) $this->image_path, '/'));
    }
}
