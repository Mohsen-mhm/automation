<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class City extends Model
{
    protected $fillable = [
        'province_id',
        'name',
        'slug',
        'active',
        'sort_order'
    ];

    protected $casts = [
        'province_id' => 'integer',
        'active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Permissions
    const CITY_INDEX = 'city-index';
    const CITY_CREATE = 'city-create';
    const CITY_EDIT = 'city-edit';
    const CITY_DELETE = 'city-delete';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($city) {
            if (empty($city->slug)) {
                $city->slug = Str::slug($city->name);
            }
        });

        static::updating(function ($city) {
            if ($city->isDirty('name')) {
                $city->slug = Str::slug($city->name);
            }
        });
    }

    /**
     * Get the province that owns the city.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Scope to get only active cities
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Scope to filter by province
     */
    public function scopeByProvince($query, $provinceId)
    {
        return $query->where('province_id', $provinceId);
    }

    /**
     * Activate the city
     */
    public function activate(): void
    {
        $this->update(['active' => true]);
    }

    /**
     * Deactivate the city
     */
    public function deactivate(): void
    {
        $this->update(['active' => false]);
    }

    /**
     * Get full name with province
     */
    public function getFullNameAttribute(): string
    {
        return $this->name . ' - ' . $this->province->name;
    }
}
