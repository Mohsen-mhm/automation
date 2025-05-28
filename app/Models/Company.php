<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    public const COMPANY_INDEX = 'company-index';
    public const COMPANY_CREATE = 'company-create';
    public const COMPANY_EDIT = 'company-edit';
    public const COMPANY_CONFIRM = 'company-confirm';
    public const COMPANY_DELETE = 'company-delete';

    protected $fillable = [
        'name',
        'type',
        'national_id',
        'registration_number',
        'registration_place',
        'registration_date',
        'climate_system',
        'feeding_system',
        'ceo_name',
        'ceo_phone',
        'ceo_national_id',
        'interface_name',
        'interface_phone',
        'company_logo',
        'brand',
        'brand_logo',
        'trademark_certificate',
        'province',
        'city',
        'address',
        'postal',
        'landline_number',
        'phone_number',
        'location_link',
        'coordinates',
        'latitude',
        'longitude',
        'website',
        'email',
        'official_newspaper',
        'operation_licence',
        'active',
        'status',
    ];

    // ---------- Relations ---------- //

    public function climateAutomations(): HasMany
    {
        return $this->hasMany(Automation::class, 'climate_company_id');
    }

    public function feedingAutomations(): HasMany
    {
        return $this->hasMany(Automation::class, 'feeding_company_id');
    }
}
