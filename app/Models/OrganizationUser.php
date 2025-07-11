<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationUser extends Model
{
    use HasFactory;

    public const ORGAN_INDEX = 'organ-index';
    public const ORGAN_CREATE = 'organ-create';
    public const ORGAN_EDIT = 'organ-edit';
    public const ORGAN_CONFIRM = 'organ-confirm';
    public const ORGAN_DELETE = 'organ-delete';

    protected $fillable = [
        'user_id',
        'fname',
        'lname',
        'national_id',
        'organization_name',
        'organization_level',
        'national_card',
        'personnel_card',
        'introduction_letter',
        'province',
        'city',
        'address',
        'postal',
        'landline_number',
        'phone_number',
        'active',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
