<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GreenhouseAlert extends Model
{
    use HasFactory;

    public const ALERT_INDEX = 'alert-index';

    protected $fillable = [
        'greenhouse_id',
        'lux_active',
        'min_lux',
        'max_lux',
        'temp_active',
        'min_temp',
        'max_temp',
        'wind_active',
        'min_wind',
        'max_wind',
        'humidity_active',
        'min_humidity',
        'max_humidity',
    ];

    public function greenhouse(): HasOne
    {
        return $this->hasOne(Greenhouse::class);
    }
}
