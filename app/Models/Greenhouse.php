<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Greenhouse extends Model
{
    use HasFactory;

    public const GREENHOUSE_INDEX = 'greenhouse-index';
    public const GREENHOUSE_CREATE = 'greenhouse-create';
    public const GREENHOUSE_EDIT = 'greenhouse-edit';
    public const GREENHOUSE_CONFIRM = 'greenhouse-confirm';
    public const GREENHOUSE_DELETE = 'greenhouse-delete';

    protected $fillable = [
        'user_id',
        'name',
        'substrate_type',
        'product_type',
        'licence_number',
        'meterage',
        'operation_date',
        'construction_date',
        'greenhouse_status',
        'owner_name',
        'owner_phone',
        'owner_national_id',
        'climate_system',
        'feeding_system',
        'province',
        'city',
        'address',
        'postal',
        'location_link',
        'coordinates',
        'latitude',
        'longitude',
        'operation_licence',
        'image',
        'active',
        'status',
        'city_id',
        'province_id',
    ];

    public function automation(): HasMany
    {
        return $this->hasMany(Automation::class);
    }

    public function alert(): HasOne
    {
        return $this->hasOne(GreenhouseAlert::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the province this company belongs to
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the city this company belongs to
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
