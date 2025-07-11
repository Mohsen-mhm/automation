<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Province extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'active',
        'sort_order'
    ];

    protected $casts = [
        'active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Permissions
    const PROVINCE_INDEX = 'province-index';
    const PROVINCE_CREATE = 'province-create';
    const PROVINCE_EDIT = 'province-edit';
    const PROVINCE_DELETE = 'province-delete';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($province) {
            if (empty($province->slug)) {
                $province->slug = Str::slug($province->name);
            }
        });

        static::updating(function ($province) {
            if ($province->isDirty('name')) {
                $province->slug = Str::slug($province->name);
            }
        });
    }

    /**
     * Get the cities for the province.
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get active cities for the province.
     */
    public function activeCities(): HasMany
    {
        return $this->cities()->where('active', true)->orderBy('sort_order');
    }

    /**
     * Scope to get only active provinces
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
     * Activate the province
     */
    public function activate(): void
    {
        $this->update(['active' => true]);
    }

    /**
     * Deactivate the province
     */
    public function deactivate(): void
    {
        $this->update(['active' => false]);
    }

    /**
     * Get cities count attribute
     */
    public function getCitiesCountAttribute(): int
    {
        return $this->cities()->count();
    }

    /**
     * Get active cities count attribute
     */
    public function getActiveCitiesCountAttribute(): int
    {
        return $this->activeCities()->count();
    }

    public function greenhouses()
    {
        return $this->hasMany(Greenhouse::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
