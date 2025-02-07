<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    public const FILTER_ACTIVE = 'filter-active';

    public const COMPANY_TYPE = 'company';
    public const GREENHOUSE_TYPE = 'greenhouse';

    public const GREENHOUSE_SUBSTRATE_FILTER = 'greenhouse_substrate_type';
    public const GREENHOUSE_PRODUCT_FILTER = 'greenhouse_product_type';
    public const GREENHOUSE_PROVINCE_FILTER = 'greenhouse_province';
    public const COMPANY_TYPE_FILTER = 'company_type';
    public const COMPANY_PROVINCE_FILTER = 'company_province';

    protected $fillable = [
        'uuid',
        'name',
        'title',
        'type',
        'active',
    ];

    public function isCompanyFilter(): bool
    {
        if ($this->type == self::COMPANY_TYPE) {
            return true;
        }
        return false;
    }

    public static function getByUuid($uuid): object|null
    {
        return self::query()->where('uuid', $uuid)->first();
    }

    public function deactivate(): void
    {
        $this->active = false;
        $this->save();
    }

    public function activate(): void
    {
        $this->active = true;
        $this->save();
    }
}
