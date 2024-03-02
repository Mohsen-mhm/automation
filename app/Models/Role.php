<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    public const ADMIN_ROLE = 'ADMIN';
    public const ORGANIZATION_ROLE = 'ORGANIZATION';
    public const COMPANY_ROLE = 'COMPANY';
    public const GREENHOUSE_ROLE = 'GREENHOUSE';

    public const ROLE_INDEX = 'role-index';
    public const ROLE_ASSIGN = 'role-assign';

    protected $fillable = [
        'name',
        'title',
    ];

    // ---------- Relations ---------- //

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    // ---------- Utility Methods ---------- //
}
