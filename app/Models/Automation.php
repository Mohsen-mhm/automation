<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Automation extends Model
{
    use HasFactory;

    public const AUTOMATION_INDEX = 'automation-index';
    public const AUTOMATION_CREATE = 'automation-create';
    public const AUTOMATION_EDIT = 'automation-edit';
    public const AUTOMATION_CONFIRM = 'automation-confirm';

    protected $fillable = [
        'greenhouse_id',
        'climate_company_id',
        'climate_date',
        'climate_api_link',
        'climate_linked_date',
        'feeding_company_id',
        'feeding_date',
        'feeding_api_link',
        'feeding_linked_date',
        'api_link',
        'linked_date',
        'active',
        'status',
    ];

    // ---------- Relations ---------- //

    public function greenhouse(): BelongsTo
    {
        return $this->belongsTo(Greenhouse::class);
    }

    public function climateCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'climate_company_id');
    }

    public function feedingCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'feeding_company_id');
    }
}
