<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Config extends Model
{
    use HasFactory;

    public const JSON_TYPE = 'json';
    public const STRING_TYPE = 'string';

    public const SUBSTRATE = 'substrate-type';
    public const PRODUCT_TYPE = 'product-type';
    public const COMPANY_TYPE = 'company-type';
    public const GREENHOUSE_TYPE = 'greenhouse-type';
    public const GREENHOUSE_STATUS = 'greenhouse-status';
    public const COMPANY_TARIFF = 'company-tariff';
    public const GREENHOUSE_TARIFF = 'greenhouse-tariff';

    public const CONFIG_INDEX = 'config-index';
    public const CONFIG_EDIT = 'config-edit';

    public const STATUS_PENDING = 'pending';
    public const STATUS_PENDING_FA = 'در انتظار تایید';
    public const STATUS_EDITED = 'edited';
    public const STATUS_EDITED_FA = 'ویرایش شده';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CONFIRMED_FA = 'تایید شده';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_REJECTED_FA = 'رد شده';
    public const STATUS_DEACTIVATE = 'deactivate';
    public const STATUS_DEACTIVATE_FA = 'غیرفعال';

    protected $fillable = [
        'name',
        'title',
        'type',
        'value',
    ];

    public static function getStatuses(): Collection
    {
        return collect([
            [
                'name' => self::STATUS_PENDING,
                'title' => self::STATUS_PENDING_FA,
            ],
            [
                'name' => self::STATUS_EDITED,
                'title' => self::STATUS_EDITED_FA,
            ],
            [
                'name' => self::STATUS_CONFIRMED,
                'title' => self::STATUS_CONFIRMED_FA,
            ],
            [
                'name' => self::STATUS_REJECTED,
                'title' => self::STATUS_REJECTED_FA,
            ],
            [
                'name' => self::STATUS_DEACTIVATE,
                'title' => self::STATUS_DEACTIVATE_FA,
            ],
        ]);
    }
}
